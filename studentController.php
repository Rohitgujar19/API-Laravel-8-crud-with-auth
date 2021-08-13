<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
use App\Models\faculty;
use App\Models\User;
class studentController extends Controller
{
    //
    function register(Request $request)
    {
      $studentData=student::create(
        [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'branch'=>$request->branch
        ]);
      if(!$studentData)
      {
        return response()->json(['message','not saved'],404);
      }
      return response()->json(['message','saved'],200);
    }
    function AddFaculty(Request $request)
    {
        $facultyData=faculty::create($request->all());
        if(!$facultyData)
        {
            return response()->json(['message','not saved'],404);
        }
        return response()->json(['message','saved'],200);
    }
    function showStudent()
    {
        $studentData=student::all();
        return response()->json($studentData,200);
    }
    function login(Request $request)
    {
        $studentData=student::where('email',$request->email)->first();
        if(!$studentData || $studentData->password!=$request->password)
        {
            return response([
              'message'=>['these Credential do not match in our records']],404
            );
        }
         $token = $studentData->createToken('my-app-token')->plainTextToken;
        $response=[
          'studentData'=>$studentData,
          'token'=>$token
        ];
        return response($response,201);
    }
    function addUser(Request $request)
    {
        //to register user who can controller student and faculty
         $userData=User::where('email',$request->email)->first();
        if($userData)
        {
            return response()->json(['message','allready exist'],409);
        }
        $user=User::create(
            [
              'name'=>$request->name,
              'email'=>$request->email,
              'password'=>$request->password
            ]);
        if(!$user)
        {
            return response()->json(['message','not saved'],404);
        }
          $response=(
            [
                'message'=>'registerd successfully',
                'data'=>$user
            ]);
          return response()->json($response,200);
    }
    function loginUser(Request $request)
    {
        $userData=User::where('email',$request->email)->first();
        if(!$userData || $userData->password!=$request->password)
        {
            return response()->json(['message','these credential do not match in our records'],404);
        }
        $token=$userData->createToken('my-app-token')->plainTextToken;
        $response=[
        'userData'=>$userData,
        'token'=>$token

        ];
        return response()->json($response,200);
    }
    function updateStudent(Request $request ,$id)
    {
        $studentData=student::where('id',$id)->first();
        if(is_null($studentData))
        {
           return response()->json(['message','not found'],404);
        }
        $studentData->update($request->all());
        return response()->json(
         [
            'message'=>'data is updated',
            'data'=>$studentData
         ],200
        );

    }
    function deleteStudent($id)
    {
        $studentData=student::where('id',$id)->first();
        $studentData->delete();
        return response()->json(['message','data is deleted'],200);
    }
}
