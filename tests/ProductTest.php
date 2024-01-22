<?php

namespace Tests;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
        public function testGetName () : void {
            $product = new Product('chaussette', ['EUR' => 8], 'alcohol');
            $name = $product->getName();
            $this->assertEquals('chaussette', $name);
        }
        public function testGetPrices(): void {
            $product = new Product('chaussette', ['EUR' => 8.2], 'alcohol');
            $price = $product->getPrices();
            $this->assertEquals(['EUR' => 8.2], $price);
        }

        public function testGetPricesWithParams () {
            $product = new Product('chaussette', ['EUR' => 8], 'alcohol');
            $price = $product->getPrice('EUR');
            $this->assertEquals(8, $price);
        }

        public function testGetPriceNotValid () {
            $product = new Product('chaussette', ['EUR' => 8], 'alcohol');
            $this->expectException(\Exception::class);
            $this->expectExceptionMessage('Invalid currency');
            $product->getPrice('GOLD');
        }
        public function testGetType () : void {
            $product = new Product('chaussette', ['EUR' => 8], 'alcohol');
            $type = $product->getType();
            $this->assertEquals('alcohol', $type);
        }
        public function testSetTypeNotValid () {
            $product = new Product('chaussette', ['EUR' => 8], 'alcohol');
            $this->expectExceptionMessage('Exception: Invalid type');
            $this->expectException(\Exception::class);
            $this->expectExceptionMessage('Invalid type');
            $product->setType('invalid_type');
        }

        /*
        public function testSetPrices () {
            $product = new Product('chaussette', ['GOLD' => 8], 'alcohol');
            $this->assertNull($product->getPrices());
        }
        */

        public function testGetTVAType() {
            $product = new Product('chaussette', ['EUR' => 8], 'alcohol');
            $tva = $product->getTVA();
            $this->assertEquals(0.2, $tva);
        }

        public function testGetTVAfood () {
            $product = new Product('chaussette', ['EUR' => 8], 'food');
            $tva = $product->getTVA();
            $this->assertEquals(0.1, $tva);
        }

        public function testListCurrencies () {
            $product = new Product('chaussette', ['EUR' => 8], 'alcohol');
            $listCurrencies = $product->listCurrencies();
            $this->assertEquals(['EUR'], $listCurrencies);
        }

}