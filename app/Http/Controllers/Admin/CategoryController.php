<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }




    public function create()
    {
        return view('admin.category.create');
    }
    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $searchValue = $request->input('search.value');

        $query = Category::query();
        $totalRecords = $query->count();

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $searchValueLower = strtolower($searchValue);

                if (strpos('active', $searchValueLower) !== false) {
                    $q->orWhere('active', 1);
                }
                if (strpos('inactive', $searchValueLower) !== false) {
                    $q->orWhere('active', 0);
                }

                $q->orWhere('name', 'like', '%' . $searchValue . '%');
            });
        }

        // $totalFiltered = $query->count();


        $totalFiltered = (clone $query)->count();

        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $categories = $query->orderBy('categories.created_at', 'desc')->get();


        $data = [];
        $i = $start + 1;

        foreach ($categories as $cat) {
            $editUrl = route('categories.edit', $cat->id);
            $deleteUrl = route('categories.destroy', $cat->id);

            $photoUrl = $cat->photo && file_exists(public_path('uploads/category/' . $cat->photo))
                ? asset('uploads/category/' . $cat->photo)
                : asset('images/default-category.png');

            $imageHtml = '<img src="' . $photoUrl . '" alt="Category Image" width="50" height="50" style="object-fit: cover; border-radius: 4px;">';

            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['name'] = $cat->name;
            $row['status'] = $cat->active == 1 ? 'Active' : 'Inactive';
            $row['image'] = $imageHtml;
            $deleteUrl = route('categories.destroy', $cat->id);
            $row['action'] = '
<div class="btn-group">
    <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem 0.5rem;">
         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1.5a1.5 1.5 0 1 1 0 3 
                1.5 1.5 0 0 1 0-3zm0 4.5a1.5 1.5 0 1 1 0 3 
                1.5 1.5 0 0 1 0-3z"/>
        </svg>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item btn-edit" href="javascript:void(0);" data-id="' . $cat->id . '">
                <i class="fas fa-edit me-1 text-primary"></i> Edit
            </a>
        </li>
        <li>
            <form action="' . $deleteUrl . '" method="POST" class="delete-category-form" style="margin:0;">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <button type="submit" class="dropdown-item text-danger category-delete-btn">
                    <i class="fas fa-trash-alt me-1"></i> Delete
                </button>
            </form>
        </li>
    </ul>
</div>';




            $data[] = $row;
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category'), $imageName);
        }

        Category::create([
            'name' => $request->name,
            'active' => $request->active,
            'photo' => $imageName,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'active' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->active = $request->active;

        if ($request->hasFile('image')) {
            if ($category->photo && file_exists(public_path('uploads/category/' . $category->photo))) {
                unlink(public_path('uploads/category/' . $category->photo));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category'), $imageName);

            $category->photo = $imageName;
        }

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->photo && file_exists(public_path('uploads/category/' . $category->photo))) {
            unlink(public_path('uploads/category/' . $category->photo));
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}
