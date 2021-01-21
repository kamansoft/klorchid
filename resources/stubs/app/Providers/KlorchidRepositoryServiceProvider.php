<?php 

namespace App\Providers; 


use Illuminate\Support\ServiceProvider; 

/** 
* Class RepositoryServiceProvider 
* @package App\Providers 
*/ 
class RepositoryServiceProvider extends ServiceProvider 
{ 
   /** 
    * Register services. 
    * 
    * @return void  
    */ 
   public function register() 
   { 
       //Here you bind your repositories in the conainer 
       //$this->app->bind(UserRepositoryInterface::class, UserRepository::class);
   }
}