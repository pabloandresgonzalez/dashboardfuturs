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
        ->orderBy('id', 'desc')
        ->paginate(50);

        return view('wallets.indexAdmin', [
        'Wallets' => $Wallets
        ]);


    }

    public function index(Request $request)
    {


          //return view('wallets.index');

          //Conseguir usuario identificado
          $user = \Auth::user();

          $id = $user->id;


          //$id = '60535b90-6a4b-42f3-b273-2989b53ad1a1';

          $data = [
          'userId' => $id, //'d33b3162-2057-4079-8447-bcfd3e52960c',
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

          //dd($err);

          //dd($result);
          curl_close($curl);
          //$data1 = print_r($result);

          //decodificar JSON 
          //$respuestaDecodificada = json_decode($result, true); 

          //$data = file_get_contents("data/products.json");
          //$totalwallet = json_decode($result, true);


          //$balanceBTC = $totalwallet['BTC']['balance'];


          //dd($respuestaDecodificada);

          //dd($result);

          $Wallets = wallet_transactions::where('user', $user->id)->orderBy('id', 'desc')
            ->paginate(30);

          /*  
          $memberships = UserMembership::where('user', $id)
                                ->where('status', 'Ce');

          dd($memberships);
          */

            
            return view('wallets.index', [
              'user' => $user,
              'Wallets' => $Wallets,
              'result' => $result,
            ]);     

      

    }

    public function store(Request $request)
    {


      //Conseguir usuario identificado
      $user = \Auth::user();
      $id = $user->id;
      $name = $user->name;
      $email = $user->email;

                
      $rules = ([
          
          'value' => 'required|string|max:255',
          'detail' => 'required|string', 
          'currency' => 'required|string', 
          'wallet' => 'required|string',         
          
      ]);

       $this->validate($request, $rules);


        $Wallet = new wallet_transactions();
        $Wallet->user = $id;
        $Wallet->email = $email;
        $Wallet->value = $request->input('value');
        $Wallet->fee = 5;
        $Wallet->type = 0;
        $Wallet->hash = '';
        $Wallet->currency = $request->input('currency');
        $Wallet->approvedBy = '';
        $Wallet->wallet = $request->input('wallet');
        $Wallet->inOut = 0;
        $Wallet->status = 'exhange';     
        $Wallet->detail = $request->input('detail');

        //dd($Wallet);
       

        $Wallet->save();// INSERT BD


        //enviar email
        $user_email = User::where('role', 'admin')->first();
        $user_email_admin = $user_email->email;
        //$useremail = 'pabloandres6@gmail.com';

        Mail::to($email)->send(new TransactionSentMessage($Wallet));

        Mail::to($user_email_admin)->send(new TransactionMessageCreated($Wallet));

        //return redirect('home');

        return redirect()->route('home')->with([
                    'message' => 'Solicitud de retiro enviado correctamente!'
        ]);

    }

    public function edit($id) {
        
        $Wallets = wallet_transactions::find($id);
        //$fecha_actual = date("Y-m-d H:i:s");


        return view('wallets.edit', [
          'Wallets' => $Wallets
      ]);

    }

    public function update(Request $request, $id)
    {

      //dd($result);

      //Conseguir usuario identificado
      $user = \Auth::user();
      $iduser = $user->id;
      //dd($id);
      //$name = $user->name;
      //$email = $user->email;

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
        $Wallet->value = $value;
        $Wallet->fee = $fee;
        $Wallet->type = $type;
        $Wallet->hash = $request->input('hash');
        $Wallet->currency = $currency;
        $Wallet->approvedBy = $iduser; 
        $Wallet->$wallet;
        $Wallet->inOut = 0;
        $Wallet->status = $request->input('status');     
        $Wallet->detail = $detail;

       

        $Wallet->save();// INSERT BD

        //enviar email
        $user_email = User::where('role', 'admin')->first();
        $user_email_admin = $user_email->email;
        //$useremail = 'pabloandres6@gmail.com';

        Mail::to($email)->send(new StatusChangeTransactionMessage($Wallet));

        Mail::to($user_email_admin)->send(new StatusChangeTransactionMessageAdmin($Wallet));
        

        //return redirect('home');

        return redirect()->route('home')->with([
                    'message' => 'Solicitud de Retiro editada correctamente!'
        ]);

    }

    public function exportExcel()
    {
      return Excel::download(new WalletTransactionsExport, 'Wallets.xlsx');
    }

    public function editsaldos(Request $request)
    {

      $users = User::where('isActive', 1)
               ->orderBy('name')
               ->get();


      //dd($users);

      $fecha_actual = date("Y-m-d H:i:s");

      //$Wallets = wallet_transactions::find($id);
        //$fecha_actual = date("Y-m-d H:i:s");

        return view('wallets.gsaldosadmin', [
          'users' => $users,
          'fecha_actual' => $fecha_actual
      ]);

    }

    public function storeadmin(Request $request)
    {


      //Conseguir usuario identificado
      $user = \Auth::user();
      $id = $user->id;
      $name = $user->name;
      $email = $user->email;

                
      $rules = ([
          
          'value' => 'required|string|max:255',
          'value' => 'required|string|max:255',
          'detail' => 'required|string', 
          //'currency' => 'required|string', 
          //'wallet' => 'required|string',         
          
      ]);

       $this->validate($request, $rules);

       $type = $request->input('type');


       $idmovimiento = $request->input('idmovimiento');

       $idmovimiento = User::where('id', $idmovimiento)->first();
       $userid = $idmovimiento->id;
       $useremail = $idmovimiento->email;

       //dd($userid);

       $memberships = UserMembership::where('user', $id)
        ->where('status', 'Activo')
        ->paginate();
       //$depositos = UserMembership::where('user', $userid);
            //->where('status', 'Activo')
            //->paginate(5);

        //dd($memberships);

        $cantmemberships = $memberships->count();

        //dd($cantmemberships);

        // Si tiene almenos una membresia activa
        if ($cantmemberships > 0) {

        $Wallet = new wallet_transactions();
        $Wallet->user = $userid;
        $Wallet->email = $useremail;
        $Wallet->value = $request->input('value');
        $Wallet->fee = 5;
        $Wallet->type = $request->input('type');
        $Wallet->hash = 'Autoriza'." ".$name."-".$email;
        $Wallet->currency = $request->input('currency');
        $Wallet->approvedBy = $id;
        $Wallet->wallet = $request->input('wallet');
        $Wallet->inOut = 0;
        $Wallet->status = 'Aprobada';     
        $Wallet->detail = $request->input('detail');

        //dd($Wallet);        

        $Wallet->save();// INSERT BD

        return redirect()->route('home')->with([
                    'message' => 'Asignación de saldo enviada correctamente!'
        ]);

        }

        //dd($memberships);

        //No tiene ninguna membresia activa

        return redirect()->route('walletadmin')->with([
                    'message' => 'El usuario no tine una membresia activa!'
        ]);


        /*
        //dd($Wallet);
       

        $Wallet->save();// INSERT BD


        //enviar email
        $user_email = User::where('role', 'admin')->first();
        $user_email_admin = $user_email->email;
        //$useremail = 'pabloandres6@gmail.com';

        Mail::to($email)->send(new TransactionSentMessage($Wallet));

        Mail::to($user_email_admin)->send(new TransactionMessageCreated($Wallet));

        //return redirect('home');

        return redirect()->route('home')->with([
                    'message' => 'Solicitud de retiro enviado correctamente!'
        ]);
        */

    }

}
