<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Http, Cache};

class ApiController extends Controller
{
    public function weather(Request $request) {
        $city = $request->get('city','Sydney');
        $key  = config('services.weather.key');
        $data = Cache::remember("weather:{$city}", 1800, function() use ($city,$key) {
            if ($key) {
                try {
                    $r = Http::timeout(5)->get("https://api.openweathermap.org/data/2.5/weather",['q'=>$city,'appid'=>$key,'units'=>'metric']);
                    if ($r->successful()) { $j=$r->json(); return ['city'=>$j['name'],'temp'=>round($j['main']['temp']),'desc'=>ucfirst($j['weather'][0]['description']),'icon'=>$j['weather'][0]['icon'],'humidity'=>$j['main']['humidity']]; }
                } catch(\Exception $e) {}
            }
            $demo=['Sydney'=>['city'=>'Sydney','temp'=>23,'desc'=>'Partly cloudy','icon'=>'02d','humidity'=>68],'Melbourne'=>['city'=>'Melbourne','temp'=>17,'desc'=>'Showers','icon'=>'10d','humidity'=>82],'Kathmandu'=>['city'=>'Kathmandu','temp'=>28,'desc'=>'Sunny','icon'=>'01d','humidity'=>45],'Brisbane'=>['city'=>'Brisbane','temp'=>29,'desc'=>'Sunny','icon'=>'01d','humidity'=>55]];
            return $demo[$city] ?? $demo['Sydney'];
        });
        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function gold() {
        $data = Cache::remember('gold_prices', 3600, function() {
            $key = config('services.metal.key');
            if ($key) {
                try {
                    $r = Http::timeout(5)->get("https://api.metalpriceapi.com/v1/latest",['api_key'=>$key,'base'=>'AUD','currencies'=>'XAU,XAG']);
                    if ($r->successful() && $r->json('success')) {
                        $rates=$r->json('rates'); $gOz=1/$rates['XAUAUD']; $sOz=1/$rates['XAGAUD'];
                        return ['gold'=>['oz'=>round($gOz,2),'gram'=>round($gOz/31.1,2),'tola'=>round(($gOz/31.1)*11.664,2)],'silver'=>['oz'=>round($sOz,2),'gram'=>round($sOz/31.1,2),'tola'=>round(($sOz/31.1)*11.664,2)],'updated_at'=>now()->format('H:i')];
                    }
                } catch(\Exception $e) {}
            }
            return ['gold'=>['oz'=>4820.50,'gram'=>155.00,'tola'=>1808.02],'silver'=>['oz'=>57.80,'gram'=>1.86,'tola'=>21.69],'updated_at'=>'Demo data'];
        });
        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function currency() {
        $data = Cache::remember('currency_rate', 3600, function() {
            try {
                $r = Http::timeout(5)->get('https://api.exchangerate-api.com/v4/latest/AUD');
                if ($r->successful()) return ['rate'=>round($r->json('rates.NPR'),2),'updated_at'=>now()->format('d M Y')];
            } catch(\Exception $e) {}
            return ['rate'=>133.45,'updated_at'=>'Demo rate'];
        });
        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function horoscope(Request $request) {
        $sign  = strtolower($request->get('sign','aries'));
        $valid = ['aries','taurus','gemini','cancer','leo','virgo','libra','scorpio','sagittarius','capricorn','aquarius','pisces'];
        if (!in_array($sign,$valid)) return response()->json(['success'=>false,'message'=>'Invalid sign'],400);
        $data = Cache::remember("horoscope:{$sign}", 86400, function() use ($sign) {
            try {
                $r = Http::timeout(8)->get("https://horoscope-app-api.vercel.app/api/v1/get-horoscope/daily",['sign'=>$sign,'day'=>'TODAY']);
                if ($r->successful() && $r->json('success')) return ['sign'=>ucfirst($sign),'horoscope'=>$r->json('data.horoscope_data'),'date'=>now()->format('d F Y')];
            } catch(\Exception $e) {}
            return ['sign'=>ucfirst($sign),'horoscope'=>'The stars shine brightly for you today. Embrace new opportunities and trust your instincts. Good things are on the horizon.','date'=>now()->format('d F Y')];
        });
        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function nepaliDate() {
        $months = ['Baisakh','Jestha','Ashadh','Shrawan','Bhadra','Ashwin','Kartik','Mangsir','Poush','Magh','Falgun','Chaitra'];
        return response()->json(['success'=>true,'data'=>['ad_date'=>now()->format('l, d F Y'),'bs_year'=>now()->year+56,'bs_month'=>$months[now()->month-1],'bs_day'=>now()->day]]);
    }
}
