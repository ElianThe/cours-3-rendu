<?php

namespace Tests;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testGetName()
    {
        $person = new Person('John', 'USD');
        $this->assertEquals('John', $person->getName());
    }

    public function testGetWallet()
    {
        $person = new Person('John', 'USD');
        $wallet = new Wallet('USD');
        $this->assertEquals($wallet ,$person->getWallet());
    }

    public function testSetWallet()
    {
        $person = new Person('Alice', 'EUR');
        $wallet = new Wallet('EUR');
        $person->setWallet($wallet);
        $this->assertSame($wallet, $person->getWallet());
    }

    public function testHasFund()
    {
        $person = new Person('Bob', 'USD');
        $wallet = new Wallet('USD');
        $wallet->addFund(50);
        $person->setWallet($wallet);
        $this->assertTrue($person->hasFund());

        $emptyPerson = new Person('Empty', 'USD');

        $this->assertFalse($emptyPerson->hasFund());
    }

    public function testTransfertFund()
    {
        $person1 = new Person('Sender', 'EUR');
        $person2 = new Person('Receiver', 'EUR');
        $person1->getWallet()->addFund(100);

        $person1->transfertFund(50, $person2);

        $this->assertSame(50.0, $person1->getWallet()->getBalance());
        $this->assertSame(50.0, $person2->getWallet()->getBalance());
    }

    public function testDivideWallet()
    {
        $person1 = new Person('Person1', 'USD');
        $person2 = new Person('Person2', 'USD');
        $person3 = new Person('Person3', 'USD');

        $person1->getWallet()->addFund(100);

        $person1->divideWallet([$person1, $person2, $person3]);

        $this->assertSame(33.34, $person1->getWallet()->getBalance());
        $this->assertSame(33.33, $person2->getWallet()->getBalance());
        $this->assertSame(33.33, $person3->getWallet()->getBalance());
    }

    public function testBuyProduct()
    {
        $person = new Person('Customer', 'EUR');
        $wallet = new Wallet('EUR');
        $wallet->addFund(50);
        $person->setWallet($wallet);

        $product = new Product('Shoes', ['EUR' => 30], 'tech');

        $person->buyProduct($product);

        $this->assertSame(20.0, $person->getWallet()->getBalance());
    }

    public function testBuyProductWithDifferentCurrency()
    {
        $person = new Person('Customer', 'USD');
        $wallet = new Wallet('USD');
        $wallet->addFund(50);
        $person->setWallet($wallet);

        $product = new Product('Shoes', ['EUR' => 30], 'tech');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can\'t buy product with this wallet currency');

        $person->buyProduct($product);
    }
}