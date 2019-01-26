<?php

namespace App\Http\Controllers;

use App\Block;
use App\Module;
use App\Service;
use App\Equipment;
use Illuminate\Http\Request;
use Auth;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$system,Module $module)
    {
        //
        $params = $request->all();
        
        
        switch ($system) {
            case 'ed_slot':
                # code...
                
                $allblocks = Block::where('module_id',$module->id)->get();
                // dd($allblacks);
                $allblocks = $allblocks->map(function ($block) use($params,$module) {
                    $curdata = explode(",", $block->data);
                    // filter for slot and date
                    if ($curdata[0]==$params['slot_id'] && $curdata[2]==$params['date']) {
                        return [
                            'id'            => $block->id,
                            'data'          => $curdata,
                            'created_at'    => $block->created_at,
                            'updated_at'    => $block->updated_at,
                            'module_id'     => $block->module_id,
                            'user_id'       => $block->user_id
                        ];
                    }else{
                        return null;
                    }
                    
                });
                // remove the null values
                $allblocks = $allblocks->filter();
                
                // ok begin filter
                // mapkan utk dpt service id je
                $allblocks = $allblocks->map(function ($block) {
                    return ['id'=>$block['data'][1],'blockid'=>$block['id']];
                });
                // dd($params['enable'],$allblocks,$params['block_by']);
                switch ($params['block_by']) {
                    case 'date':
                        # code...
                        break;
                    case 'slot':
                        # code...
                        if ($params['enable']=="true") {
                            $unblocked_item = 0;
                            foreach ($allblocks as $key => $value) {
                                # code...
                                $entityblock = Block::find($value['blockid']);
                                $entityblock->delete();
                                $unblocked_item +=1;
                            }
                            if ($allblocks->count() == $unblocked_item) {
                                return response()->json([
                                    'status' => 200,
                                    'msg' => 'done unblock'
                                ]);
                            }
                        }else{
                            
                            $services = Service::all()->filter(function ($item) use ($allblocks) {
                                            if (!$allblocks->contains('id', $item->id)) {
                                                return $item;
                                            }
                                        });
                            $blocked_item = 0;

                            foreach ($services as $service) {
                                $blocking = new Block;
                                $blocking->data = $params['slot_id'].','.$service->id.','.$params['date'];
                                $blocking->module_id = $module->id;
                                $blocking->user_id = Auth::user()->id;
                                if ($blocking->save()) {
                                    $blocked_item += 1;
                                }
                                
                            }
                            if ($services->count() == $blocked_item) {
                                return response()->json([
                                    'status' => 200,
                                    'msg' => 'done block'
                                ]);
                            }
                        
                        }
                        break;
                    case 'equipment':
                        # code...
                        if ($params['enable']=="true") {
                            $unblocked_item = 0;
                            foreach ($allblocks as $key => $value) {
                                # code...
                                $entityblock = Block::find($value['blockid']);
                                $entityblock->delete();
                                $unblocked_item +=1;
                            }
                            if ($allblocks->count() == $unblocked_item) {
                                return response()->json([
                                    'status' => 200,
                                    'msg' => 'done unblock'
                                ]);
                            }
                        }else{
                            $services = Equipment::find($params['equipment_id'])->services->filter(function ($item) use ($allblocks) {
                                            if (!$allblocks->contains('id', $item->id)) {
                                                return $item;
                                            }
                                            // if (in_array($item->id, $allblocks)) {
                                            //     return $item;
                                            // }
                                        });//->pluck('id');
                            $blocked_item = 0;
                            foreach ($services as $service) {
                                $blocking = new Block;
                                $blocking->data = $params['slot_id'].','.$service->id.','.$params['date'];
                                $blocking->module_id = $module->id;
                                $blocking->user_id = Auth::user()->id;
                                if ($blocking->save()) {
                                    $blocked_item += 1;
                                }
                                
                            }
                            if ($services->count() == $blocked_item) {
                                return response()->json([
                                    'status' => 200,
                                    'msg' => 'done block'
                                ]);
                            }
                        }
                        
                        break;
                    case 'service':
                        # code...
                        if ($params['enable']=="true") {
                            $unblocked_item = 0;
                            foreach ($allblocks as $key => $value) {
                                # code...
                                $entityblock = Block::find($value['blockid']);
                                $entityblock->delete();
                                $unblocked_item +=1;

                            }
                            if ($allblocks->count() == $unblocked_item) {
                                return response()->json([
                                    'status' => 200,
                                    'msg' => 'done unblock'
                                ]);
                            }
                        }else{
                            $service = Service::find($params['service_id']);
                            if (!$allblocks->contains('id', $service->id)) {
                                $blocked_item = 0;
                                $blocking = new Block;
                                $blocking->data = $params['slot_id'].','.$service->id.','.$params['date'];
                                $blocking->module_id = $module->id;
                                $blocking->user_id = Auth::user()->id;
                                if ($blocking->save()) {
                                    $blocked_item += 1;
                                }
                                return response()->json([
                                    'status' => 200,
                                    'msg' => 'done block'
                                ]);
                            }
                        }
                        break;
                    
                    default:
                        # code...
                        break;
                }
                return response()->json([
                                'status' => 300,
                                'msg' => 'something went wrong somewhere'
                            ]);
                break;
            
            default:
                # code...
                break;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Block $block)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        //
    }
}
