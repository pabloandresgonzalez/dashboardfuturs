<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserMembership;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Membresia;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusChangeMessage;
use App\Mail\MembershipCreatedMessage;
use App\Mail\MembershipPurchaseMessage;
use App\Exports\UsersMembershipsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\wallet_transactions;


class UserMembershipController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $nombre = $request->get('buscarpor');
        

        $memberships = UserMembership::where('membership', 'LIKE', "%$nombre%")
        ->orwhere('user_name', 'LIKE', "%$nombre%")
        ->orwhere('user_email', 'LIKE', "%$nombre%")
        ->orwhere('hashUSDT', 'LIKE', "%$nombre%")
        ->orwhere('hashPSIV', 'LIKE', "%$nombre%")
        ->orwhere('status', 'LIKE', "%$nombre%")
        ->orderBy('id', 'desc')
        ->paginate(50);

        $totalusers = User::count();

        return view('memberships.index', [
        'memberships' => $memberships,
        'totalusers' => $totalusers
        ]);

        /*

        $memberships = UserMembership::orderBy('id', 'Desc')->paginate(10);
        $data = ['memberships' => $memberships];

        return view('memberships.index', compact('memberships'));
        */

    }

    public function create()
    {

        //Conseguir usuario identificado
        $user = \Auth::user();

        //Conseguir UserMembership de usuario identificado
        $memberships = UserMembership::where('user', $user->id)->orderBy('id', 'desc')->get()->toArray();

        //dd($memberships);

        //Conseguir membresias 
        //$membresias = DB::table('membresias')->pluck()->toArray();
        $membresias = Membresia::orderBy('id', 'Desc')->get();
        


        //dd($membresias); 
        $totalusers = User::count();


        return view('memberships.create', compact('membresias', 'totalusers'));


    }

    public function edit($id) {
        
        $memberships = UserMembership::find($id);
        $fecha_actual = date("Y-m-d H:i:s");
        $totalusers = User::count();


        return view('memberships.edit', [
          'memberships' => $memberships,
          'fecha_actual' => $fecha_actual,
          'totalusers' => $totalusers
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
            
            //'membership' => 'required|string|min:4', 
            'id_membresia' => 'required|string',  //|unique:user_memberships|min:4 
            'hashUSDT' => 'required|max:255|unique:user_memberships', //|unique:user_memberships
            'hashPSIV' => 'required|max:255|unique:user_memberships', //|unique:user_memberships
            'image' => 'file',             
            
        ]);

       $this->validate($request, $rules);

       //dd($request);

       $id_membresia = Membresia::find($id);

       $membresia = Membresia::find($request->input('id_membresia'));
       $namemembresia =$membresia->name;
       
        //dd($namemembresia);
          

        $fecha_actual = date("Y-m-d H:i:s");

        $membership = new UserMembership();
        $membership->id_membresia = $request->input('id_membresia');
        $membership->membership = $namemembresia;
        $membership->user_email = $email;
        $membership->user = $id;
        $membership->user_name = $name;
        $membership->hashUSDT = $request->input('hashUSDT');
        $membership->hashPSIV = $request->input('hashPSIV'); 
        $membership->detail = 'Pendiente';
        $membership->status = 'Pendiente';
        $membership->closedAt = null;
        $membership->activedAt = null;

        //Subir la imagen imagehash
        $image_photo = $request->file('image');
        if ($image_photo) {

          //Poner nombre unico
          $image_photo_name = time() . $image_photo->getClientOriginalName();

          //Guardarla en la carpeta storage (storage/app/imagehash)
          Storage::disk('imagehash')->put($image_photo_name, File::get($image_photo));

          //Seteo el nombre de la imagen en el objeto
          $membership->image = $image_photo_name;
        }


        $membership->save();// INSERT BD

        //Enviar email
        $user_email = User::where('role', 'admin')->first();
        $user_email_admin = $user_email->email;
        //$user_email_admin = 'pabloandres6@gmail.com';

        Mail::to($user_email_admin)->send(new MembershipCreatedMessage($membership));

        Mail::to($email)->send(new MembershipPurchaseMessage($membership));

        //return redirect('home');
        $totalusers = User::count();

        return redirect()->route('home')->with([
                    'message' => 'Hash enviado correctamente!',
                    'totalusers' => $totalusers
        ]);

    }

    public function update(Request $request, $id)
    {      

        /*
        //Conseguir usuario identificado
        $user = \Auth::user();
        $id = $user->id;

        $membership = UserMembership::findOrFail($id);
        $membership->hash;
        */

        //Validacion del formulario
        $validate = $this->validate($request, [
            'membership' => 'required|string|min:4',        
            //'hashUSDT' => 'required|max:255|unique:user_memberships',
            //'hashPSIV' => 'required|max:255|unique:user_memberships',
            'activedAt'=>'required|date_format:Y-m-d H:i:s',
            //'activedAt' => 'required|max:255',
            //'closedAt' => 'required|max:255', 
            //'detail' => 'required|max:255',     
            'image' => 'file',
        ]);


        $fecha_actual = date("Y-m-d H:i:s");

        $membership = UserMembership::findOrFail($id);
        $membership->membership = $request->input('membership');
        //$membership->hashUSDT = $request->input('hashUSDT');
        //$membership->hashPSIV = $request->input('hashPSIV');
        $membership->detail = $request->input('status');
        $membership->activedAt = $request->input('activedAt');
        $membership->closedAt = $request->input('closedAt');
        $membership->status = $request->input('status');

        //Subir la imagen photo
        $image_photo = $request->file('image');
        if ($image_photo) {

          //Poner nombre unico
          $image_photo_name = time() . $image_photo->getClientOriginalName();

          //Guardarla en la carpeta storage (storage/app/imagehash)
          Storage::disk('imagehash')->put($image_photo_name, File::get($image_photo));

          //Seteo el nombre de la imagen en el objeto
          $membership->image = $image_photo_name;
        }

        $membership->save(); //INSERT BD

        //Enviar email
        $user_email = $membership->user_email;

        Mail::to($user_email)->send(new StatusChangeMessage($membership));

        $totalusers = User::count();

        return redirect()->route('home')->with([
                    'message' => 'Membership editado correctamente!',
                    'totalusers' => $totalusers
        ]);

    }

    public function indexUserMemberships() {

    //Conseguir usuario identificado
    $user = \Auth::user();
    //$id = $user->id;
    //$name = $user->name;
    //$image = $user->image;
    //$users = User::orderBy('id', 'desc')->get();
    $memberships = UserMembership::where('user', $user->id)->orderBy('id', 'desc')
            ->paginate(30);

        //dd($memberships);
    $totalusers = User::count();

        return view('memberships.mismemberships', [
            'memberships' => $memberships,
            'user' => $user,
            'totalusers' => $totalusers
        ]);

    }
    
    public function getImage($filename)
    {

        $file = Storage::disk('imagehash')->get($filename);
        return new Response($file, 200);
    }

    public function orden($id)
    {
        $membership = UserMembership::find($id);
        $totalusers = User::count();

        return view('memberships.soporte', [
            'membership' => $membership,
            'totalusers' => $totalusers
        ]);

    }

    public function pagos(Request $request, $id)
    {
        $totalusers = User::count();
        $membership = UserMembership::findOrFail($id);        
        //$networktransaction = NetworkTransaction::findOrFail($request->user);
        //dd($membership);
        return view('networktransaction.index', compact('totalusers'));

    }

    public function editrenovar($id)
    {
        //Conseguir usuario identificado
        $user = \Auth::user();
        $iduser= $user->id;

        $memberships = UserMembership::where('user', $iduser)
        ->where('status', 'Activo')
        ->paginate(50);
       //$depositos = UserMembership::where('user', $userid);
            //->where('status', 'Activo')
            //->paginate(5);

        //dd($memberships);

        $cantmemberships = $memberships->count();

        $memberships = UserMembership::find($id);
        //dd($memberships);

        //dd($cantmemberships);

        if ($cantmemberships > 0) {
            
          //dd($cantmemberships);
          //echo "con membresa activa";

           //Conseguir usuario identificado
          $user = \Auth::user();

          $id = $user->id;

          $totalusers = User::count();


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
          
          return view('memberships.renovar', [
                'memberships' => $memberships,
                'user' => $user,
                'result' => $result,
                'totalusers' => $totalusers
                ]);             

        }

            //echo "sin membresa activa";

            return redirect()->route('home')->with([
                'message' => 'Debes tener saldo o una membresía activa para renovar!',
                'totalusers' => $totalusers
            ]); 


        /*
        $memberships = UserMembership::find($id);
        //dd($memberships);

        return view('memberships.renovar', [
          'memberships' => $memberships
          ]);
        */

    }

    public function renovar(Request $request, $id)
    {
        //dd($id);

        //Conseguir usuario identificado
        $user = \Auth::user();
        $iduser = $user->id;
        $name = $user->name;
        $email = $user->email;

        $totalusers = User::count();

        $membershippadre = UserMembership::findOrFail($id);
        $id_membresia = $membershippadre->id_membresia;
        $typeHash =  $membershippadre->typeHash;

        //dd($typeHash);

        $membresia = Membresia::where('id', $id_membresia)->first();
        $valor_membresia = $membresia->valor;

        $data = [
          'userId' => $iduser, //'d33b3162-2057-4079-8447-bcfd3e52960c',
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

          //decodificar JSON porque esa es la respuesta
          $respuestaDecodificada = json_decode($result);  
          $url = ($result);
              $data = json_decode($url, true);
              $totalPSIV = $data['USDT']['total'];
              $totalUSDT = $data['PSIV']['total'];

              $total = $totalPSIV + $totalUSDT;

          //dd($totalPSIV);


          $valor_saldo  = $total;
             

        //dd($valor_membresia);

        if ($valor_membresia > $valor_saldo) {
            
            return redirect()->route('home')->with([
                    'message' => 'Saldo insuficiente para renovar!',
                    'totalusers' => $totalusers
                ]); 

        }

     
        //dd($id_membresia);

        //Validacion del formulario
        $validate = $this->validate($request, [
            'membership' => 'required|string|min:4',        
            //'hashUSDT' => 'required|max:255|unique:user_memberships', 
            //'hashPSIV' => 'required|max:255|unique:user_memberships',
            //'detail' => 'required|max:255', 
            //'activedAt' => 'required|max:255',
            //'closedAt' => 'required|max:255',    
            //'image' => 'file',
        ]);    

        $membership = new UserMembership();
        $membership->id_membresia = $id_membresia;
        $membership->membresiaPadre = $id;
        $membership->membership = $request->input('membership');
        $membership->user_email = $email;
        $membership->user = $iduser;
        $membership->user_name = $name;
        $membership->hashUSDT = 'Descuento de saldo '.bin2hex(random_bytes(20));
        $membership->hashPSIV = 'Descuento de saldo '.bin2hex(random_bytes(20));
        //$membership->typeHash = $typeHash;     
        $membership->detail = 'Activo';
        $membership->status = 'Activo';
        $membership->closedAt = null;
        $fecha_actual = date("Y-m-d H:i:s");
        $membership->activedAt = $fecha_actual;

        //Subir la imagen imagehash
        $image_photo = $request->file('image');
        if ($image_photo) {

          //Poner nombre unico
          $image_photo_name = time() . $image_photo->getClientOriginalName();

          //Guardarla en la carpeta storage (storage/app/imagehash)
          Storage::disk('imagehash')->put($image_photo_name, File::get($image_photo));

          //Seteo el nombre de la imagen en el objeto
          $membership->image = $image_photo_name;
        }

        //dd($membership);

        $membershipInicial = UserMembership::findOrFail($id);
        $membershipInicial->status = 'Terminada';
        $membershipInicial->detail = 'Terminada';

        $membership->save();// INSERT BD
        $membershipInicial->save();

        $Wallet = new wallet_transactions();
        $Wallet->user = $iduser;
        $Wallet->email = $email;
        $value = $valor_membresia / 2 + 2.5;
        $Wallet->value = $value;
        $Wallet->fee = 5 / 2;
        $Wallet->type = 0;
        $Wallet->hash = 'Descuento para renovar '.bin2hex(random_bytes(20));
        $Wallet->currency = 'PSIV';
        $Wallet->approvedBy = $email;
        $Wallet->wallet = $request->input('WalletPSIV');
        $Wallet->inOut = 0;
        $Wallet->status = 'Aprobada';     
        $Wallet->detail = 'Descuento para renovar membresia';

        //dd($Wallet);       

        $Wallet->save();// INSERT BD

        $membershipInicial = UserMembership::findOrFail($id);
        $membershipInicial->status = 'Terminada';
        $membershipInicial->detail = 'Terminada';

        $membership->save();// INSERT BD
        $membershipInicial->save();

        $Wallet = new wallet_transactions();
        $Wallet->user = $iduser;
        $Wallet->email = $email;
        $value = $valor_membresia / 2 + 2.5;
        $Wallet->value = $value;
        $Wallet->fee = 5 / 2 ;
        $Wallet->type = 0;
        $Wallet->hash = 'Descuento para renovar '.bin2hex(random_bytes(20));
        $Wallet->currency = 'USDT';
        $Wallet->approvedBy = $email;
        $Wallet->wallet = $request->input('WalletUSDT');
        $Wallet->inOut = 0;
        $Wallet->status = 'Aprobada';     
        $Wallet->detail = 'Descuento para renovar membresia';

        //dd($Wallet);       

        $Wallet->save();// INSERT BD
        

        return redirect()->route('home')->with([
                    'message' => 'Hash de renovación enviado correctamente!',
                    'totalusers' => $totalusers
                    
        ]);
        
        /*
        //dd($id);

        //Conseguir usuario identificado
        $user = \Auth::user();
        $iduser = $user->id;
        $name = $user->name;
        $email = $user->email;

        $membershippadre = UserMembership::findOrFail($id);
        $id_membresia = $membershippadre->id_membresia;

       
        //dd($id_membresia);

        //Validacion del formulario
        $validate = $this->validate($request, [
            'membership' => 'required|string|min:4',        
            'hashUSDT' => 'required|max:255|unique:user_memberships', 
            'hashPSIV' => 'required|max:255|unique:user_memberships',
            //'detail' => 'required|max:255', 
            //'activedAt' => 'required|max:255',
            //'closedAt' => 'required|max:255',    
            'image' => 'file',
        ]);  

        //dd($validate);    

        $membership = new UserMembership();
        $membership->id_membresia = $id_membresia;
        $membership->membresiaPadre = $id;
        $membership->membership = $request->input('membership');
        $membership->user_email = $email;
        $membership->user = $iduser;
        $membership->user_name = $name;
        $membership->hashUSDT = $request->input('hashUSDT');
        $membership->hashPSIV = $request->input('hashPSIV');     
        $membership->detail = 'X renovar';
        $membership->status = 'Pendiente';
        $membership->closedAt = null;
        $membership->activedAt = null;


        //Subir la imagen imagehash
        $image_photo = $request->file('image');
        if ($image_photo) {

          //Poner nombre unico
          $image_photo_name = time() . $image_photo->getClientOriginalName();

          //Guardarla en la carpeta storage (storage/app/imagehash)
          Storage::disk('imagehash')->put($image_photo_name, File::get($image_photo));

          //Seteo el nombre de la imagen en el objeto
          $membership->image = $image_photo_name;
        }

        //dd($membership);

        $membershipInicial = UserMembership::findOrFail($id);
        $membershipInicial->status = 'Terminada';

        $membership->save();// INSERT BD
        $membershipInicial->save();
        

        return redirect()->route('home')->with([
                    'message' => 'Hash de renovación enviado correctamente!'
        ]);
        */

    }

    public function detail($id) {

      $membership = UserMembership::find($id);
      $totalusers = User::count();

      return view('memberships.detail', [
          'membership' => $membership,
          'totalusers' => $totalusers
      ]);
    }

    public function exportExcel()
    {
      return Excel::download(new UsersMembershipsExport, 'memberships.xlsx');
    }
    
}

