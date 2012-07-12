<?php

class TempStorageTest extends UpdateTestCase
{


    public function testStorage()
    {
        $tmpStorage = new IpUpdate\Library\Model\TempStorage(TMP_DIR);
        $key1 = 'key1';
        $val1 = 'val1';

        $this->assertEquals($tmpStorage->exist($key1), false);

        $tmpStorage->setValue($key1, 'val1');

        $this->assertEquals($tmpStorage->exist($key1), true);
        $this->assertEquals($tmpStorage->getValue($key1), $val1);

        $tmpStorage->remove($key1);
        $this->assertEquals($tmpStorage->exist($key1), false);
    }



}
