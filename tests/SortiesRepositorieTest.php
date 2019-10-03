<?php


namespace App\Tests;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use PHPUnit\Framework\TestCase;

class SortiesRepositorieTest  extends TestCase{


    public function __construct()
    {

    }
     public function testAdd()
    {
        $employee = new Employee();
        $employee->setSalary(1000);
        $employee->setBonus(1100);

        // Now, mock the repository so it returns the mock of the employee
        $employeeRepository = $this->createMock(ObjectRepository::class);
        // use getMock() on PHPUnit 5.3 or below
        // $employeeRepository = $this->getMock(ObjectRepository::class);
        $employeeRepository->expects($this->any())
            ->method('find')
            ->willReturn($employee);

        // Last, mock the EntityManager to return the mock of the repository
        // (this is not needed if the class being tested injects the
        // repository it uses instead of the entire object manager)
        $objectManager = $this->createMock(ObjectManager::class);
        // use getMock() on PHPUnit 5.3 or below
        // $objectManager = $this->getMock(ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($employeeRepository);

      //  $salaryCalculator = new SalaryCalculator($objectManager);
        //$this->assertEquals(2100, $salaryCalculator->calculateTotalSalary(1));
    }
}
