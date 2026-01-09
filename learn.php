<?php
class Counter {
    public static $count = 0;
    
    public static function increment() {
        self::$count++;  // self:: pour accéder aux membres statiques
    }
}

Counter::increment();
Counter::increment();
echo Counter::$count; // Affiche 2