<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wallet_transactions;
use App\Mail\TransactionSentMessage;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\TransactionMessageCreated;
use App\Exports\WalletTransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserMembership;
use App\Mail\StatusChangeTransactionMessage;
use App\Mail\StatusChangeTransactionMessageAdmin;
use DateTime;
use DB;

class WalletTransactionsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function indexAdmin(Request $request)
    {

      $nombre = $request->get('buscarpor');

        $Wallets = wallet_transactions::where('user', 'LIKE', "%$nombre%")
        ->orwhere('email', 'LIKE', "%$nombre%")
        ->orwhere('currency', 'LIKE', "%$nombre%")
        ->orwhere('type', 'LIKE', "%$nombre%")
        ->orwhere('status', 'LIKE', "%$nombre%")
        ->orwhere('created_at', 'LIKE', "%$nombre%")
        ->orderBy('created_at', 'desc')
        ->paginate(50);

        // Total comission del usuario mes en curso
        $totalCommission = $this->totalCommission();

        // Hitorial de produccion 
        $totalProduction = $this->totalProduction();

        // Total produccion del usuario mes en curso
        $totalProductionMes = $this->totalProductionMes();

        // Total usuarios
        $totalusers = $totalusers = $this->countUsers();

        return view('wallets.indexAdmin', [
        'Wallets' => $Wallets,
        'totalusers' => $totalusers,
        'totalCommission' => $totalCommission,
        'totalProduction' => $totalProduction,
        'totalProductionMes' => $totalProductionMes
        ]);


    }

    public function index(Request $request)
    {

      //Conseguir usuario identificado
      $user = \Auth::user();

      $id = $user->id;


      $data = [
      'userId' => $id,
      'token' => 'AcjAa76AHxGRdyTemDb2jcCzRmqpWN'
      ];

      $curl = curl_init();

      curl_setopt_array($curl, array(
          CURLOPT_URL => "https://sd0fxgedtd.execute-api.us-east-2.amazonaws.com/Prod_getBalanceByUser",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30000,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($data),        
          CURLOPT_HTTPHEADER => array(
            // Set here requred headers
              "accept: */*",
              "accept-language: en-US,en;q=0.8",
              "content-type: application/json",
          ),
      ));

      $result = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      //decodificar JSON porque esa es la respuesta
      $respuestaDecodificada = json_decode($result); 
      //dd($respuestaDecodificada); 

      $Wallets = wallet_transactions::where('user', $user->id)->orderBy('id', 'desc')
        ->paginate(50);

      // Total comission del usuario mes en curso
      $totalCommission = $this->totalCommission();

      // Hitorial de produccion 
      $totalProduction = $this->totalProduction();

      // Total produccion del usuario mes en curso
      $totalProductionMes = $this->totalProductionMes();

      // Total usuarios
      $totalusers = $totalusers = $this->countUsers();

        
        return view('wallets.index', [
          'user' => $user,
          'Wallets' => $Wallets,
          'result' => $result,
          'totalusers' => $totalusers,
          'totalCommission' => $totalCommission,
          'totalProduction' => $totalProduction,
          'totalProductionMes' => $totalProductionMes
        ]); 
    }

    private function countUsers()
    {
      // Conseguir usuario identificado
      $user = \Auth::user();
      $id = $user->id;

      // Total usuarios
      $totalusers = DB::table('users')
            ->where('ownerId', $id)->count();

      return $totalusers;
    }

    private function totalCommission()
    {
      // Conseguir usuario identificado
      $user = \Auth::user();
      $id = $user->id;

      /*// Total, de comisión por activación de membresías de usuarios referidos 
      $totalCommission = DB::table("network_transactions")
      ->where('user', $id)
      ->where('type', 'Activation')      
      ->get()->sum("value");*/

      $totalCommission1 = DB::select("SELECT * FROM network_transactions 
        WHERE YEAR(created_at) = YEAR(CURRENT_DATE()) 
        AND MONTH(created_at)  = MONTH(CURRENT_DATE())
        AND type = 'Activation'
        AND status = 'Activa'
        AND user = ?", [$id]);

      $valores = array_column($totalCommission1, 'value');
      $totalCommission = array_sum($valores);

      return $totalCommission;
    }

    private function totalProduction()
    {
      // Conseguir usuario identificado
      $user = \Auth::user();
      $id = $user->id;

      // Total usuarios
      $totalProduction = DB::table("network_transactions")
      ->where('user', $id)
      ->where('type', 'Daily')
      ->get()->sum("value");

      return $totalProduction;
    }

    private function totalProductionMes()
    {
      // Conseguir usuario identificado
      $user = \Auth::user();
      $id = $user->id;

      $totalProductionMes1 = DB::select("SELECT * FROM network_transactions 
        WHERE YEAR(created_at) = YEAR(CURRENT_DATE()) 
        AND MONTH(created_at)  = MONTH(CURRENT_DATE())
        AND type = 'Daily'
        AND status = 'Activa'
        AND user = ?", [$id]);

      $valores = array_column($totalProductionMes1, 'value');
      $totalProductionMes = array_sum($valores);

      return $totalProductionMes;
    }

    public function store(Request $request)
    {

      //Conseguir usuario identificado
      $user = \Auth::user();
      $id = $user->id;
      $name = $user->name;
      $email = $user->email;

      $id = $user->id;


      $data = [
      'userId' => $id,
      'token' => 'AcjAa76AHxGRdyTemDb2jcCzRmqpWN'
      ];

      $curl = curl_init();

      curl_setopt_array($curl, array(
          CURLOPT_URL => "https://sd0fxgedtd.execute-api.us-east-2.amazonaws.com/Prod_getBalanceByUser",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30000,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($data),        
          CURLOPT_HTTPHEADER => array(
            // Set here requred headers
              "accept: */*",
              "accept-language: en-US,en;q=0.8",
              "content-type: application/json",
          ),
      ));

      $result = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      //decodificar JSON porque esa es la respuesta
      $respuestaDecodificada = json_decode($result); 
      
      $url = ($result);
      $data = json_decode($url, true);
      $totalPSIV = $data['PSIV']['total'];
      $totalUSDT = $data['USDT']['total'];
                
      $rules = ([
          
          'value' => 'required|string|max:255',
          'detail' => 'required|string', 
          'currency' => 'required|string', 
          'wallet' => 'required|string',         
          
      ]);

       $this->validate($request, $rules);

       // $idmovimiento = $request->input('idmovimiento');
       
       $idmovimiento = User::where('id', $id)->first();
       $userid = $idmovimiento->id;
       $useremail = $idmovimiento->email;


       $memberships = UserMembership::where('user', $userid)
        ->where('status', 'Activo')->get();

        $cantmemberships = $memberships->count();

        // Si tiene almenos una membresia activa
        if ($cantmemberships > 0) {

        $Wallet = new wallet_transactions();
        $Wallet->user = $id;
        $Wallet->email = $email;


        $dia1 = date('Y-m-01');
        $fecha_actual = date("Y-m-d");

        //$dias_habiles = bussiness_days($dia1, $fecha_actual);

        //dd($dias_habiles);


        $fecha1= new DateTime($dia1);
        $fecha2= new DateTime($fecha_actual);
        $diff = $fecha1->diff($fecha2);
       

        $percentageda = 12;
        $percentagedp = 8;        
        $valretiro = $request->input('value');  

        if ($valretiro > $totalPSIV || $valretiro > $totalUSDT) {

          return redirect()->route('home')->with([
                    'message' => '¡' . $name . ' ' . '¡El valor del traslado no puede ser mayor al saldo disponible!'
                    //'totalusers' => $totalusers
          ]); 

        } else {

          $toPorretiroda = ($percentageda * $valretiro) / 100;
          $toPorretirodp = ($percentagedp * $valretiro) / 100;

        if ($diff->days < 15) {
          $Wallet->fee = $toPorretiroda;
          $Wallet->value = $valretiro - $toPorretiroda;
        } else {
          $Wallet->fee = $toPorretirodp;
          $Wallet->value = $valretiro - $toPorretiroda;
        }
        

        //$Wallet->fee = 5;

        $Wallet->type = "Traslado";
        $Wallet->hash = '';
        $Wallet->currency = $request->input('currency');
        $Wallet->approvedBy = '';
        $Wallet->wallet = $request->input('wallet');
        $Wallet->inOut = 0;
        $Wallet->status = 'exhange';     
        $Wallet->detail = $request->input('detail');


        $Wallet->save();// INSERT BD


        //enviar email
        $user_email = User::where('role', 'admin')->first();
        $user_email_admin = $user_email->email;
        //$user_email_admin = 'pabloandres6@gmail.com';

        Mail::to($email)->send(new TransactionSentMessage($Wallet));

        Mail::to($user_email_admin)->send(new TransactionMessageCreated($Wallet));

        // Total comission del usuario mes en curso
        $totalCommission = $this->totalCommission();

        // Hitorial de produccion 
        $totalProduction = $this->totalProduction();

        // Total produccion del usuario mes en curso
        $totalProductionMes = $this->totalProductionMes();

        // Total usuarios
        $totalusers = $totalusers = $this->countUsers();

        return redirect()->route('home')->with([
                    'message' => '¡' . $name .' ' . '¡solicitud de traslado enviada correctamente!',
                    'totalusers' => $totalusers,
                    'totalCommission' => $totalCommission,
                    'totalProduction' => $totalProduction,
                    'totalProductionMes' => $totalProductionMes
        ]);

        }
                  
      }

        return redirect()->route('home')->with([
                    'message' => '¡' . $name . ' ' . '¡es necesario tener mínimo una membresía activa para poder hacer traslados!'
                    //'totalusers' => $totalusers
        ]);  
       

    }

    public function edit($id) {
        
        $Wallets = wallet_transactions::find($id);

        // Total comission del usuario mes en curso
        $totalCommission = $this->totalCommission();

        // Hitorial de produccion 
        $totalProduction = $this->totalProduction();

        // Total produccion del usuario mes en curso
        $totalProductionMes = $this->totalProductionMes();

        // Total usuarios
        $totalusers = $totalusers = $this->countUsers();

        return view('wallets.edit', [
          'Wallets' => $Wallets,
          'totalusers' => $totalusers,
          'totalCommission' => $totalCommission,
          'totalProduction' => $totalProduction,
          'totalProductionMes' => $totalProductionMes
      ]);

    }

    public function update(Request $request, $id)
    {

      //Conseguir usuario identificado
      $user = \Auth::user();
      $iduser = $user->id;


      $Wallet = wallet_transactions::find($id);
      $user = $Wallet->user;
      $email = $Wallet->email;
      $value = $Wallet->value;
      $detail = $Wallet->detail;
      $type = $Wallet->type;
      $currency = $Wallet->currency;
      $wallet = $Wallet->wallet;
      $fee = $Wallet->fee;

                
      $rules = ([
          
          //'value' => 'required|string|max:255',
          //'detail' => 'required|string', 
          'hash' => 'required|max:255|unique:wallet_transactions',
          'status' => 'required|string|max:50',

          
      ]);

       $this->validate($request, $rules);

        $Wallet = wallet_transactions::findOrFail($id);
        $Wallet->user = $user;
        $email = $email;
        if ($request->input('status') === 'Rechazado') {
          $Wallet->value = 0;
          $Wallet->fee = 0;
          $Wallet->status = '';
        } else {
          $Wallet->value = $value;
          $Wallet->fee = $fee;
          $Wallet->status = $request->input('status');
        }        
        
        $Wallet->type = $type;
        $Wallet->hash = $request->input('hash');
        $Wallet->currency = $currency;
        $Wallet->approvedBy = $iduser; 
        $Wallet->$wallet;
        $Wallet->inOut = 0;     
        $Wallet->detail = $detail . ', ' . $request->input('hash');
       

        $Wallet->save();// INSERT BD

        //enviar email
        $user_email = User::where('role', 'admin')->first();
        $user_email_admin = $user_email->email;
        //$user_email_admin = 'pabloandres6@gmail.com';

        Mail::to($email)->send(new StatusChangeTransactionMessage($Wallet));

        Mail::to($user_email_admin)->send(new StatusChangeTransactionMessageAdmin($Wallet));        

        // Total comission del usuario mes en curso
        $totalCommission = $this->totalCommission();

        // Hitorial de produccion 
        $totalProduction = $this->totalProduction();

        // Total produccion del usuario mes en curso
        $totalProductionMes = $this->totalProductionMes();

        // Total usuarios
        $totalusers = $totalusers = $this->countUsers();

        return redirect()->route('home')->with([
                    'message' => 'Solicitud de traslado editada correctamente!',
                    'totalusers' => $totalusers,
                    'totalCommission' => $totalCommission,
                    'totalProduction' => $totalProduction,
                    'totalProductionMes' => $totalProductionMes
        ]);

    }

    public function exportExcel()
    {
      return Excel::download(new WalletTransactionsExport, 'Traslados.xlsx');
    }

    public function editsaldos(Request $request)
    {

      $users = User::where('isActive', 1)
               ->orderBy('name')
               ->get();


      $fecha_actual = date("Y-m-d H:i:s");

      // Total comission del usuario mes en curso
      $totalCommission = $this->totalCommission();

      // Hitorial de produccion 
      $totalProduction = $this->totalProduction();

      // Total produccion del usuario mes en curso
      $totalProductionMes = $this->totalProductionMes();

      // Total usuarios
      $totalusers = $totalusers = $this->countUsers();

        return view('wallets.gsaldosadmin', [
          'users' => $users,
          'fecha_actual' => $fecha_actual,
          'totalusers' => $totalusers,
          'totalCommission' => $totalCommission,
          'totalProduction' => $totalProduction,
          'totalProductionMes' => $totalProductionMes
      ]);

    }

    public function storeadmin(Request $request)
    {

      //Conseguir usuario identificado
      $user = \Auth::user();
      $id = $user->id;
      $name = $user->name;
      $email = $user->email;

      // Total comission del usuario mes en curso
      $totalCommission = $this->totalCommission();

      // Hitorial de produccion 
      $totalProduction = $this->totalProduction();

      // Total produccion del usuario mes en curso
      $totalProductionMes = $this->totalProductionMes();

      // Total usuarios
      $totalusers = $totalusers = $this->countUsers();

                
      $rules = ([
          
          'idmovimiento' => 'required|string|max:255',
          'value' => 'required|string|max:255',
          'type' => 'required|string|max:255',
          'detail' => 'required|string', 
          //'currency' => 'required|string', 
          //'wallet' => 'required|string',         
          
      ]);

       $this->validate($request, $rules);


       $idmovimiento = $request->input('idmovimiento');

       $idmovimiento = User::where('id', $idmovimiento)->first();
       $userid = $idmovimiento->id;
       $useremail = $idmovimiento->email;


       $memberships = UserMembership::where('user', $id)
        ->where('status', 'Activo')->get();

        $cantmemberships = $memberships->count();

        //wallet_transactions de retiro
        $Wallet = new wallet_transactions();
        $Wallet->user = $userid;
        $Wallet->email = $useremail;
        $Wallet->value = $request->input('value');
        $Wallet->fee = 0;
        $type = $request->input('type');        
        $Wallet->type = $request->input('type'); 
        $Wallet->hash = 'Autoriza'." ".$name."-".$email;
        $Wallet->currency = $request->input('currency');
        $Wallet->approvedBy = $id;
        $Wallet->wallet = null;

        if ($type === "Traslado") {
          $Wallet->inOut = 0;
        } else {
          $Wallet->inOut = 1;
        }
                
        //$Wallet->inOut = 0;
        $Wallet->status = 'Aprobada';     
        $Wallet->detail = $request->input('detail');

        $Wallet->save();// INSERT BD

        return redirect()->route('home')->with([
                    'message' => 'Asignación de saldo enviada correctamente!',
                    'totalusers' => $totalusers,
                    'totalCommission' => $totalCommission,
                    'totalProduction' => $totalProduction,
                    'totalProductionMes' => $totalProductionMes
        ]);

    }
}