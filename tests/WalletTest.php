<?php

namespace Tests;

use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    public function testGetCurrency()
    {
        $wallet = new Wallet('USD');
        $this->assertEquals('USD', $wallet->getCurrency());
    }

    public function testGetBalance()
    {
        $wallet = new Wallet('EUR');
        $this->assertEquals(0, $wallet->getBalance());

        $wallet->addFund(50);
        $this->assertEquals(50, $wallet->getBalance());
    }

    public function testSetBalance()
    {
        $wallet = new Wallet('USD');

        $wallet->setBalance(100);
        $this->assertEquals(100, $wallet->getBalance());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid balance');
        $wallet->setBalance(-50);
    }

    public function testSetCurrency()
    {
        $wallet = new Wallet('USD');

        $wallet->setCurrency('EUR');
        $this->assertEquals('EUR', $wallet->getCurrency());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid currency');
        $wallet->setCurrency('GBP');
    }

    public function testRemoveFund()
    {
        $wallet = new Wallet('USD');

        $wallet->setBalance(100);
        $wallet->removeFund(50);
        $this->assertEquals(50, $wallet->getBalance());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid amount');
        $wallet->removeFund(-30);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Insufficient funds');
        $wallet->removeFund(60);
    }

    public function testAddFund()
    {
        $wallet = new Wallet('USD');

        $wallet->addFund(50);
        $this->assertEquals(50, $wallet->getBalance());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid amount');
        $wallet->addFund(-30);
    }
}