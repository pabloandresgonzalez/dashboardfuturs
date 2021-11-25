<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membresia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\Membership;
use App\Models\User;

class MembresiaController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {        
        //$membresias = Membresia::all();
        $totalusers = User::count();
        $membresias = Membresia::orderBy('id', 'Desc')->paginate(30);
        $data = ['membresias' => $membresias];

        return view('membresias.index', compact('membresias', 'totalusers'));

    }

    public function create()
    {
      // Total de usuarios
      $totalusers = User::count();

      return view('membresias.create', compact('totalusers'));

    }

    public function perfomrValidationCreate(Request $request)
    {
        $rules = [
        'name' => 'required|string|min:4|max:255',
        'isActive' => 'required|string|max:255',
        'detail' => 'required|string|max:255',
        'valor' => 'required|string|max:255',
        'image' => 'file',

      ];

        $messages =[

          'name.required' => 'Es necesario ingresar el nombre',
          'name.min' => 'El nombre de la membresía debe tener al menos 4 caracteres',
          'isActive.required' => 'Es necesario ingresar el estado',
          'valor.required' => 'Es necesario ingresar el valor',
          'detail.required' => 'Es necesario ingresar el detalle de la membresía ',

        ];

    $this->validate($request, $rules, $messages);

    }

    public function store(Request $request)
    {

        $this->perfomrValidationCreate($request);


        $membresia = new Membresia();
        $membresia->name = $request->input('name');
        $membresia->isActive = $request->input('isActive');
        $membresia->valor = $request->input('valor');
        $membresia->detail = $request->input('detail');

        //Subir la imagen photo
        $image_photo = $request->file('image');
        if ($image_photo) {

          //Poner nombre unico
          $image_photo_name = time() . $image_photo->getClientOriginalName();

          //Guardarla en la carpeta storage (storage/app/photoMembership)
          Storage::disk('photoMembership')->put($image_photo_name, File::get($image_photo));

          //Seteo el nombre de la imagen en el objeto
          $membresia->photo = $image_photo_name;
        }

        $membresia->save(); //INSERT BD

        // Total de usuarios
        $totalusers = User::count();

        return redirect('membresias')->with([
                'message' => 'La membresía '.$membresia->name.' fue creada correctamente!',
                'totalusers' => $totalusers
        ]);

    }

    public function indexuser()
    {     

      $membresias = Membresia::orderBy('id', 'Desc')->paginate(10);
      $data = ['membresias' => $membresias];

      // Total de usuarios
      $totalusers = User::count();        

      return view('membresias.indexuser', compact('membresias', 'totalusers'));

    }

    public function edit($id)
    {
        
      $membresias = Membresia::find($id);

      $totalusers = User::count();

      return view('membresias.edit', [
        'membresias' => $membresias,
        'totalusers' => $totalusers
      ]);

  }

    public function update(Request $request, $id)
    {

      //Validacion del formulario
      $validate = $this->validate($request, [
          'name' => 'required|string|min:4|max:255',
          'isActive' => 'required|string|max:255',
          'detail' => 'required|string|max:255',
          'valor' => 'required|string|max:255',
          'image' => 'file'
      ]);


      $membresia = Membresia::findOrFail($id);
      $membresia->name = $request->input('name');
      $membresia->isActive = $request->input('isActive');
      $membresia->valor = $request->input('valor');
      $membresia->detail = $request->input('detail');

      //Subir la imagen photo
      $image_photo = $request->file('image');
      if ($image_photo) {

        //Poner nombre unico
        $image_photo_name = time() . $image_photo->getClientOriginalName();

        //Guardarla en la carpeta storage (storage/app/photoMembership)
        Storage::disk('photoMembership')->put($image_photo_name, File::get($image_photo));

        //Seteo el nombre de la imagen en el objeto
        $membresia->image = $image_photo_name;
      }

      $membresia->save(); //INSERT BD

      $totalusers = User::count();

      return redirect('membresias')->with([
              'message' => 'La membresía '.$membresia->name.' fue actualizada correctamente!',
              'totalusers' => $totalusers
      ]);

    }

    public function createMemberchip()
    {  
        $totalusers = User::count();

        return view('memberchip.index', compact('totalusers'));        

    }

    public function detail($id)
    {

      $membresia = Membresia::find($id);
      $totalusers = User::count();

      return view('membresias.detail', [
          'membresia' => $membresia,
          'totalusers' => $totalusers
      ]);
    }

}

