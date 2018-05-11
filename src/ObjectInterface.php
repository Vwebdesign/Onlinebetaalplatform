<?php

namespace OBP;

interface ObjectInterface
{
    public function __construct(array $settings = []);

    public function doRequest(): array;
}