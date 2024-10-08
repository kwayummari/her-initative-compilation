<?php
class Connect extends PDO
{
    public function __construct()
    {
        // parent::__construct("mysql:host=localhost;dbname=herinit_her", 'herinit_her', 'Gudboy24@');
        parent::__construct("mysql:host=localhost;dbname=u750269652_her", 'u750269652_her', 'Gudboy24@');
    $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
}
?>