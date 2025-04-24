<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\PagesCms;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function getDatatable()
    {
        $pages = PagesCms::with('components'); // Include relasi

        return DataTables::of($pages)
            ->addColumn('status_badge', function ($page) {
                return '<span class="badge ' . ($page->status === 'published' ? 'bg-label-success' : 'bg-label-secondary') . '">' . ucfirst($page->status) . '</span>';
            })
            ->addColumn('components_list', function ($page) {
                if ($page->components->count()) {
                    $list = '<ul class="mb-0">';
                    foreach ($page->components as $component) {
                        $list .= '<li><strong>' . ucfirst($component->type) . '</strong>';
                        if ($component->settings && isset($component->settings['title'])) {
                            $list .= ' - ' . $component->settings['title'];
                        }
                        $list .= '</li>';
                    }
                    $list .= '</ul>';
                    return $list;
                }
                return '<em>Tidak ada</em>';
            })
            ->addColumn('action', function ($page) {
                $edit = route('pages.edit', $page);
                $delete = route('pages.destroy', $page);
                return '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="' . $edit . '"><i class="ti ti-pencil me-2"></i> Edit</a>
                        <form action="' . $delete . '" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus halaman ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="dropdown-item text-danger"><i class="ti ti-trash me-2"></i> Hapus</button>
                        </form>
                    </div>
                </div>';
            })
            ->rawColumns(['status_badge', 'components_list', 'action'])
            ->make(true);
    }
    public function index()
    {
        return view('admin.pages.cms.pages.index');
    }
}
