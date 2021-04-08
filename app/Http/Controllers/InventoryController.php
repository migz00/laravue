<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        return Inventory::all();
    }

    public function store(Request $request)
    {
        $newItem = new Inventory;

        $newItem->item_code = $request->item['item_code'];
        $newItem->item_desc = $request->item['item_desc'];
        $newItem->qty = $request->item['qty'];
        $newItem->unit_of_measure = $request->item['unit_of_measure'];
        $newItem->price = $request->item['price'];
        $newItem->location = $request->item['location'];
        $newItem->type = $request->item['type'];
        $newItem->serial = $request->item['serial'];
        $newItem->model = $request->item['model'];

        $newItem->save();

        return($newItem);
    }

    public function update(Request $request)
    {
        $update = Inventory::find($request->item['id']);

        $update->item_desc = $request->item['item_desc'];
        $update->qty = $request->item['qty'];
        $update->unit_of_measure = $request->item['unit_of_measure'];
        $update->price = $request->item['price'];
        $update->location = $request->item['location'];
        $update->type = $request->item['type'];
        $update->serial = $request->item['serial'];
        $update->model = $request->item['model'];

        $update->save();

        return($update);
    }

    public function destroy(Request $request)
    {
        $item = Inventory::find($request->id);
        $item->delete();

        return($request->item);
    }
}
