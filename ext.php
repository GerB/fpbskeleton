<?php

namespace ger\fpbskeleton;

class ext extends \phpbb\extension\base
{
    public function is_enableable()
    {
		return class_exists('\ger\feedpostbot\ext');
    }
}
