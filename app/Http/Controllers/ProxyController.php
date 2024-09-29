<?php

namespace App\Http\Controllers;

use App\Models\Proxy;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    public function addProxy(){
        return view('pages.add-proxy');
    }

    public function updateProxy(Request $request){
        Proxy::truncate();
        // Lấy dữ liệu từ textarea name="proxy"
        $proxiesData = $request->input('proxy');

        // Tách proxy theo từng dòng
        $proxies = explode(PHP_EOL, $proxiesData);

        // Biến lưu proxy hợp lệ
        $validProxies = [];

        // Duyệt qua từng dòng và xử lý proxy
        foreach ($proxies as $proxy) {
            // Loại bỏ khoảng trắng thừa
            $proxy = trim($proxy);

            // Tách proxy thành các thành phần ip, port, user, password
            $parts = explode(':', $proxy);

            // Kiểm tra nếu proxy có đủ 4 phần (ip:port:user:password)
            if (count($parts) === 4) {
                $validProxies[] = [
                    'ip' => $parts[0],
                    'port' => $parts[1],
                    'username' => $parts[2],
                    'password' => $parts[3],
                    'is_live' => false, // Khởi tạo proxy với trạng thái chưa kiểm tra
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        // Nếu có proxy hợp lệ, lưu vào database
        if (count($validProxies) > 0) {
            Proxy::insert($validProxies);
            return back()->with('success', 'Proxies added successfully!');
        }

        return back()->with('error', 'No valid proxies were provided.');

    }
}
