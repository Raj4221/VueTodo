@extends('layouts.app')
  @section('content') 
  <header class="sticky-top">
        <div class="container-fluid bg-dark text-white">
            <div class="container">
                <div class="row p-1">
                    <div class="col-12 text-center">
                        <h3><b>Register</b></h3>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container add" style="text-align: center;width: 50%;margin-top: 15px">
        <todo-component></todo-component>
    </div>
    <br>
    
  @endsection