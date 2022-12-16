<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\TemplateField;
use File;

class TemplateController extends Controller
{
	public function getTemplateList(Request $request){
        $templates = Template::with('category')->where('status',1)->get();
        return response()->json($templates, 200);
    }
    
    public function getTemplate(Request $request,$template_id){
        $template = Template::where('id',$template_id)->first();
        return response()->json($template, 200);
    }
    
    public function getTemplateData(Request $request, $template_name){
        $template = Template::where('name',$template_name)->first();
        $template_fields = $template->fields()->get();
        
	
        return response()->json($template_fields, 200);
    }

    public function updateTemplateData(Request $request, $template_name){
        
	
        $template = Template::where('name',$template_name)->first();
        
        $params = $request->all();
   
        // $params['data'] = json_decode($params['data']);
        foreach($params['data'] as $componentname => $component_property){
            foreach($component_property as $propertyname => $property_value){
                $template_field = $template->fields()->where('component',$componentname)->where('property',$propertyname)->first();
                
                if($template_field){
                    if($template_field->type != 'image'){
                        $template_field->value = $property_value;
                        $template_field->save();
                    }else{
                    	$image_base64 = base64_encode($property_value);
            	        // $image = str_replace(' ', '+', $image_base64);
				        $imageName = time().'.'.'jpeg';
				        $destinationPath = public_path('images/');
				        File::put($destinationPath."". $imageName, $property_value);
				        $template_field->save();
                    	// $destinationPath = 'uploads';
                    	
                    	// $file = $property_value;
                    	// $filename = $file->getClientOriginalName();
                    	// $file->move($destinationPath,$filename);
                    	// $template_field->value = $filename;
                     //   $template_field->save();
                    }
                }
            }
        }
        
        $template_fields = $template->fields()->get();
        return response()->json($template_fields, 200);
    }
}
