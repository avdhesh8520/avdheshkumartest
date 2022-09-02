<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    function index()
    {
        $response = DB::select("SELECT P.*,C.lang,C.name as text
        FROM `tree_entry` as P JOIN tree_entry_lang as C on p.entry_id=C.entry_id WHERE 1 ORDER BY C.name");
        
        $data = [];
        $parentID = 0;
        if(count($response)>0)
        {
            $data = $this->getParentChild($parentID);
        }
        //echo "<pre>";print_r($data);die;
        return view('welcome',compact('data'));
    }
    function getParentChild($parentID)
    {
        $response = DB::select('SELECT P.*,C.lang,C.name
        FROM `tree_entry` as P JOIN tree_entry_lang as C on p.entry_id=C.entry_id WHERE p.parent_entry_id="'.$parentID.'" ORDER BY C.name ASC');
        $array = array();
        foreach($response as $res)
        {
            $id = $res->entry_id;
            $array[$id]['text'] = $res->name;
            $nodes = array_values($this->getParentChild($res->entry_id));
            if($nodes)
            {
                $array[$id]['nodes'] = $nodes;
            }
        }
        return $array;
    }
    function getTreeAjax()
    {
        $response = DB::select("SELECT P.*,C.lang,C.name as text
        FROM `tree_entry` as P JOIN tree_entry_lang as C on p.entry_id=C.entry_id WHERE 1 ORDER BY C.name");
        
        $data = [];
        $parentID = 0;
        if(count($response)>0)
        {
            $data = $this->getParentChild($parentID);
        }
        foreach($data as $level1) { ?>
        <li><span class="collapsin"><?php echo $level1['text']  ?></span>
            <?php if(count($level1['nodes'])>0){ ?>
            <ul class="leafs">
            <?php foreach($level1['nodes'] as $level2) { ?>
            <li><span class="<?php if(isset($level2['nodes']) && count($level2['nodes'])>0){ echo 'collapsin'; } ?>"><?php echo $level2['text']  ?></span>
                <?php if(isset($level2['nodes']) && count($level2['nodes'])>0){  ?>
                <ul class="leafs">
                    <?php foreach($level2['nodes'] as $level3) { ?>
                    <li><span class="<?php if(isset($level3['nodes']) && count($level3['nodes'])>0){ echo 'collapsin'; } ?>"><?php echo $level3['text']  ?></span>
                        <?php if(isset($level3['nodes']) && count($level3['nodes'])>0){  ?>
                        <ul class="leafs">
                                <?php foreach($level3['nodes'] as $level4) { ?>
                                <li><span class="<?php if(isset($level4['nodes']) && count($level4['nodes'])>0){ echo 'collapsin'; } ?>"><?php echo $level4['text']  ?></span>
                                <?php } ?>
                        </ul>
                        <?php } ?>
    
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
    
            </li>
            <?php } ?>
            </ul>
        <?php } ?>
        </li>
        <?php }
    }
}

