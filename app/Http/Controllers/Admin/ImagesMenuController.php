<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyImagesMenuRequest;
use App\Http\Requests\StoreImagesMenuRequest;
use App\Http\Requests\UpdateImagesMenuRequest;
use App\Models\ImagesMenu;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ImagesMenuController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('images_menu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ImagesMenu::query()->select(sprintf('%s.*', (new ImagesMenu)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'images_menu_show';
                $editGate      = 'images_menu_edit';
                $deleteGate    = 'images_menu_delete';
                $crudRoutePart = 'images-menus';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('images', function ($row) {
                if (! $row->images) {
                    return '';
                }
                $links = [];
                foreach ($row->images as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'images']);

            return $table->make(true);
        }

        return view('admin.imagesMenus.index');
    }

    public function create()
    {
        abort_if(Gate::denies('images_menu_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.imagesMenus.create');
    }

    public function store(StoreImagesMenuRequest $request)
    {
        $imagesMenu = ImagesMenu::create($request->all());

        foreach ($request->input('images', []) as $file) {
            $imagesMenu->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $imagesMenu->id]);
        }

        return redirect()->route('admin.images-menus.index');
    }

    public function edit(ImagesMenu $imagesMenu)
    {
        abort_if(Gate::denies('images_menu_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.imagesMenus.edit', compact('imagesMenu'));
    }

    public function update(UpdateImagesMenuRequest $request, ImagesMenu $imagesMenu)
    {
        $imagesMenu->update($request->all());

        if (count($imagesMenu->images) > 0) {
            foreach ($imagesMenu->images as $media) {
                if (! in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $imagesMenu->images->pluck('file_name')->toArray();
        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $imagesMenu->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.images-menus.index');
    }

    public function show(ImagesMenu $imagesMenu)
    {
        abort_if(Gate::denies('images_menu_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.imagesMenus.show', compact('imagesMenu'));
    }

    public function destroy(ImagesMenu $imagesMenu)
    {
        abort_if(Gate::denies('images_menu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $imagesMenu->delete();

        return back();
    }

    public function massDestroy(MassDestroyImagesMenuRequest $request)
    {
        $imagesMenus = ImagesMenu::find(request('ids'));

        foreach ($imagesMenus as $imagesMenu) {
            $imagesMenu->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('images_menu_create') && Gate::denies('images_menu_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ImagesMenu();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
