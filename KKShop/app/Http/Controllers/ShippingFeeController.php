<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Wards;
use App\Models\Province;
use App\Models\ShippingFee;
use Session;
use App\Http\Requests; 

use Illuminate\Support\Facades\Redirect; //nhu return tra ve nhung chi vao ten tren link

class ShippingFeeController extends Controller
{
    //kiem tra xem co dang nhap hay khong neu khong tra ve login admin
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function them_shippingfee(){
        $this->Authlogin();
    	$city = City::orderby('matp','ASC')->get();
    	return view('Admin.ShippingFee.them_shippingfee')->with(compact('city'));
    }
    public function select_shippingfee(Request $request){
        $this->Authlogin();
	   $data = $request->all();
        if($data['action']){
    		$output = '';
    		if($data['action']=="city"){
    			$select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
    				$output.='<option>---Quận huyện---</option>';
    			foreach($select_province as $key => $province){
    				$output.='<option value="'.$province->maqh.'">'.$province->qh_ten.'</option>';
    			}

    		}else{

    			$select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
    				$output.='<option>---xã phường thị trấn---</option>';
    			foreach($select_wards as $key => $ward){
    				$output.='<option value="'.$ward->xaid.'">'.$ward->xptt_ten.'</option>';
    			}
    		}
    		echo $output;
    	}
    }
    public function luu_shippingfee(Request $request){
        $this->Authlogin();
        $get_xaid = ShippingFee::where('xaid',$request->wards)->first();
        $output = '';
        if($get_xaid == null){
        	$shippingfee = new ShippingFee();
            $shippingfee->xaid = $request->wards;
            // $shippingfee->matp = $request->city;
            // $shippingfee->maqh = $request->province;
            $shippingfee->fee = $request->fee;
            $shippingfee->save();
            $output = '<p style="color:red;">Thêm phí vận chuyển thành công!</p>'; 
        }else {
            $output = '<p style="color:red;">Đã tồn tại phí vận chuyển cho địa chỉ này bạn có thể thay đổi phí vận chuyển phí dưới</p>';
        }
        echo $output;
    }
    public function xem_shippingfee(){
        $this->Authlogin();
        $shippingfee = ShippingFee::orderby('sf_id','DESC')->get();
        $output ='';
        $output.= '<br>
        <div class="table-agile-info">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Phí vận chuyển 
                </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Tỉnh thành phố</th>
                            <th>Quận huyện</th>
                            <th>Xã phường thị trấn</th>
                            <th>Phí ship</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
        foreach ($shippingfee as $key => $val) {
            $output.='
                        <tr>
                            <td>'.$val->Wards->Province->City->tp_ten.'</td>
                            <td>'.$val->Wards->Province->qh_ten.'</td>
                            <td>'.$val->Wards->xptt_ten.'</td>
                            <td class="edit_fee" contenteditable data-sf_id="'.$val->sf_id.'">'.$val->fee.'</td>
                        </tr>  
                    '; 

                }                  
        $output.='
                    </tbody>
                </table>
            </div>
            </div>
            </div>
                ';

        echo $output;
    }
    public function luu_fee(Request $request){
        $this->Authlogin();
        $output = '';
        if($request->fee >= 10000) {
            $shippingfee = ShippingFee::find($request->sf_id);
            $shippingfee->fee = $request->fee;
            $shippingfee->save();
            $output = '<p style="color:red;">cập nhật phí vận chuyển thành công!</p>'; 
        }else{
            $output = '<p style="color:red;">Phí vận chuyển thấp nhất là: 10.000, cập nhật không thành công!</p><br>'; 
        }
        echo $output;
    }
        
    	
}

