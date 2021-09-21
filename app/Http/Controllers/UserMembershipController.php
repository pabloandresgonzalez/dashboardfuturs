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
        ->orwhere('hashBTC', 'LIKE', "%$nombre%")
        ->orwhere('status', 'LIKE', "%$nombre%")
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('memberships.index', [
        'memberships' => $memberships
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


        return view('memberships.create', compact('membresias'));


    }

    public function edit($id) {
        
        $memberships = UserMembership::find($id);


        return view('memberships.edit', [
          'memberships' => $memberships
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
            'hashBTC' => 'required|max:255|unique:user_memberships', //|unique:user_memberships
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
        $membership->hashBTC = $request->input('hashBTC'); 
        $membership->detail = 'Pendiente';
        $membership->status = 'Pendiente';
        $membership->closedAt = $fecha_actual; //imagehash

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

        //return redirect('home');

        return redirect()->route('home')->with([
                    'message' => 'Hash enviado correctamente!'
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
            //'hashBCT' => 'required|max:255|unique:user_memberships',
            'closedAt' => 'required|max:255',
            'detail' => 'required|max:255',     
            'image' => 'file',
        ]);

        $membership = UserMembership::findOrFail($id);
        $membership->membership = $request->input('membership');
        //$membership->hashUSDT = $request->input('hashUSDT');
        //$membership->hashBTC = $request->input('hashBTC');
        $membership->detail = $request->input('detail');
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

        return redirect()->route('home')->with([
                    'message' => 'Membership editado correctamente!'
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
            ->paginate(5);

        //dd($memberships);

        return view('memberships.mismemberships', [
            'memberships' => $memberships,
            'user' => $user
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

        return view('memberships.soporte', [
            'membership' => $membership
        ]);

    }

    public function pagos(Request $request, $id)
    {
        
        $membership = UserMembership::findOrFail($id);
        //dd($membership);
        return view('memberships.historialpagos');

    }

    public function editrenovar($id) {
        
        $memberships = UserMembership::find($id);
        //dd($memberships);

        return view('memberships.renovar', [
          'memberships' => $memberships
      ]);

    }

    public function renovar(Request $request, $id)
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
            //'membership' => 'required|string|min:4',        
            //'hash' => 'required|max:255|unique:user_memberships', 
            //'typeHash' => 'required|max:255',  
            //'detail' => 'required|max:255',     
            //'image' => 'file',
        ]);


        $membership = UserMembership::findOrFail($id);
        //$membership->membership = $request->input('membership');
        //$membership->typeHash = $request->input('typeHash');
        //$membership->detail = $request->input('detail');
        $membership->detail = 'Pendiente';
        $membership->status = 'X Renovar';

        $membership->save(); //INSERT BD

        return redirect()->route('home')->with([
                    'message' => 'Membership editado correctamente!'
        ]);

    }



    
}

