<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCasesMenuRequest;
use App\Http\Requests\StoreCasesMenuRequest;
use App\Http\Requests\UpdateCasesMenuRequest;
use App\Models\CasesMenu;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CasesMenuController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('cases_menu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CasesMenu::query()->select(sprintf('%s.*', (new CasesMenu)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'cases_menu_show';
                $editGate      = 'cases_menu_edit';
                $deleteGate    = 'cases_menu_delete';
                $crudRoutePart = 'cases-menus';

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
            $table->editColumn('case_name', function ($row) {
                return $row->case_name ? $row->case_name : '';
            });
            $table->editColumn('car_make', function ($row) {
                return $row->car_make ? $row->car_make : '';
            });
            $table->editColumn('car_year', function ($row) {
                return $row->car_year ? $row->car_year : '';
            });

            $table->editColumn('parts', function ($row) {
                return $row->parts ? $row->parts : '';
            });
            $table->editColumn('parts_price', function ($row) {
                return $row->parts_price ? $row->parts_price : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.casesMenus.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cases_menu_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.casesMenus.create');
    }

    public function store(StoreCasesMenuRequest $request)
    {
        $casesMenu = CasesMenu::create($request->all());

        return redirect()->route('admin.cases-menus.index');
    }

    public function edit(CasesMenu $casesMenu)
    {
        abort_if(Gate::denies('cases_menu_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.casesMenus.edit', compact('casesMenu'));
    }

    public function update(UpdateCasesMenuRequest $request, CasesMenu $casesMenu)
    {
        $casesMenu->update($request->all());

        return redirect()->route('admin.cases-menus.index');
    }

    public function show(CasesMenu $casesMenu)
    {
        abort_if(Gate::denies('cases_menu_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.casesMenus.show', compact('casesMenu'));
    }

    public function destroy(CasesMenu $casesMenu)
    {
        abort_if(Gate::denies('cases_menu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $casesMenu->delete();

        return back();
    }

    public function massDestroy(MassDestroyCasesMenuRequest $request)
    {
        $casesMenus = CasesMenu::find(request('ids'));

        foreach ($casesMenus as $casesMenu) {
            $casesMenu->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
