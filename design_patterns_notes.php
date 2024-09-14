
<!-- Design patterns solve programming problem

DRY - Don't Repeat Yourself
KISS - Keep It Stupid Simple

Types of Design patterns
- Creational Patterns
- Structural Patterns
- Behavioural Patterns

Creational Patterns
- Class Instantiation
- Hiding the creation logic
- Examples: Factory,Builder,Prototype,Singleton

Structural Patterns
- Composition between objects
- Usages of Interfaces, abstract classes
- Examples: Adapter,Bridge,Decorator,Facade,Proxy

Behavioural Patterns
- Commuinication between objects
- Usages of mostly Interfaces
- Examples: Command,Iterator,Observer,State,Strategy

Design patterns in laravel

-Factory Pattern
-Builder (Manager) Pattern
-Strategy Pattern
-Provider Pattern
-Repository Pattern
-Iterator Pattern
-Singleton Pattern
-Presenter Pattern

-Factory Pattern : Provides an Interface for creating objects without specificfying their concrete class.
eg. using interface and classess.

interface PizzaFactoryContract
{
   public function make(array $toppings = [] );
}

class PizzaFactory implements PizzaFactoryContract
{
   public function make(array $toppings = [])
   {
       return new Pizza($toppings);
   }
}

$pizza = (new PizzaFactory)->make(['chicken','onion']);


-Builder (Manager) Pattern : Builds complex objects step by step.It can return different objects based on given data.

interface PizzaBuilderInterface
{
   public function prepare();
   public function applyTopping();
   public function bake();
}

class PizzaBuilder
{
    public function make(PizzaBuilderInterface $pizza)
    {
        return $pizza
               ->prepare()
               ->applyToppings()
               ->bake();
    }
}

class MargarithaBuilder implements PizzaBuilderInterface
{
   protected $pizza;

   public function prepare(){
      $this->pizza = new Pizza ();
      return $this->pizza;
   }
   
   public function applyToppings(){
      $this->pizza->setToppings(['cheese','tomato']);
      return $this->pizza;
   }

   public function bake(){
      $this->pizza->setBakingTemperature(180);
      $this->pizza->setBakingMinutes(8);
      return $this->pizza;
   }
}

class ChickenBuilder implements PizzaBuilderInterface
{
   protected $pizza;

   public function prepare(){
      $this->pizza = new Pizza ();
      return $this->pizza;
   }
   
   public function applyToppings(){
      $this->pizza->setToppings(['cheese','tomato','onion','Chicken']);
      return $this->pizza;
   }

   public function bake(){
      $this->pizza->setBakingTemperature(200);
      $this->pizza->setBakingMinutes(8);
      return $this->pizza;
   }
}

$pizzaBuilder = new PizzaBuilder;

$pizzaOne = $pizzaBuilder->make(new MargarithaBuilder());
$pizzaTwo = $pizzaBuilder->make(new ChickenBuilder());


Strategy Pattern : Define a family of algorithms that are interchangeable.Program to interface
,not an implementation.This is an example open and close principle


-->

