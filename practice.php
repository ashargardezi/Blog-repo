<!DOCTYPE html>
<html>

<body>

    <?php

    //     class person
    //     {

    //         public $name = "ashar";

    //         function show()
    //         {
    //             return $this->name;
    //         }
    //     }

    //     $c = new person();
    //    echo $c->show();


    //    



    // class calculation{

    // public $a, $b,$c;
    // function sum() {
    //     $this->c = $this->a +$this->b;
    //     return $this->c;


    // }
    // function sub() {
    //     $this->c = $this->a - $this->b;
    //     return $this->c;


    // }


    // };

    // $c1 = new calculation();
    // $c1->a =10;
    // $c1->b=20;
    // echo "sum = " . $c1->sum() . "<\n>";

    // $c1->a =110;
    // $c1->b=210;
    // echo " substraction = ".$c1->sub();


    //  constructor
    // class person{
    //     public $name, $age;
    //     public $name = " no name";
    //     public $age = "0";
    //    function __construct($n1 = "no name ",$n2 = "0"){
    //     $this->name = $n1;
    //     $this->age = $n2;

    //    }


    //    function show(){

    //     var_dump([$this->name, $this->age]) ;
    //    }


    // }
    // $p1 = new person("ashar ",20);
    // $p1->name = "ashar ";
    // $p1->age = 25;
    //  $p1->show();


    //  inheritance in php


    // class employe
    // {      // this is base class
    //     public $name;
    //     public $age;
    //     public $salary;

    //     function __construct($n1, $n2, $n3)
    //     {
    //         $this->name = $n1;
    //         $this->age = $n2;
    //         $this->salary = $n3;
    //     }


    //     function show()
    //     {
    //         echo "<h1>Employee name: $this->name</h1>";
    //         echo "<h1>Employee age: $this->age</h1>";
    //         echo "<h1>Employee salary: $this->salary</h1>";


    //         print_r([$this->name, $this->age,   $this->salary]);
    //     }
    // }


    // class manager extends employe
    // {

    //     public $mobile  = 1000;
    //     public $fuele = 20000;
    //     public $total_salary;

    //     function show()
    //     {
    //         $this->total_salary = $this->mobile + $this->fuele;
    //         echo "<h1>Employee name: $this->name</h1>";
    //         echo "<h1>Employee age: $this->age</h1>";
    //         echo "<h1>Employee salary: $this->total_salary</h1>";

    //         print_r([$this->name, $this->age,   $this-> total_salary]);
    //     }
    // }



    // $m1 = new manager("ashar", 34, 120000);
    // $m1->show();


    // class base{
    //     // public $name;  // when it is publich it can be acces anywhere in the c
    //     private $name;

    //      function __construct($n)

    //     {
    //         $this->name =$n;
            
    //     }

    //     function show(){
    //        echo $this->name;
            
    //     }

    // }

    // class drive extends base{

    //     // function showdrive(){
    //     //     echo $this->name;
             
    //     //  }
    // }

    // $n1 = new base("my name is  = ashar");
    // // $n1->name= "qasim";

    // $n1->show();



    // methof over riding 

//     class base{

//         public $a;
//         public $b;
//         function __construct($n,$n1)
//         { $this->a = $n;
//          $this->b = $n1;
//         }
        
//         function calculate(){
//             return $this->a + $this->b;
//         }

//     }

//     class drive extends base{

     
//         public $a;
//         public $b;
//         function __construct($n,$n1)
//         { $this->a = $n;
//          $this->b = $n1;
            
//         }
//         // function calculate(){
//         //     return $this->a * $this->b;
//         // }
//     }

    
// $a= new drive(10,5);
        
// echo $a->calculate();


// abstract classes

abstract class base {
protected $name;
// function __construct($n)
// {
//     $this->name = $n;

// }
abstract function calculate ($a);
    
}

class drive extends base{


    public function calculate($a)
    {
        echo $this->name = $a;
    }


}


$a = new drive ();
$a->calculate("ashar");
    ?>

</body>

</html>