<?php

namespace MessageCloud\Send\Interfaces;

interface UriQueryable
{
    /**
     * @return string[]
     */
    public function getUriQueryParams(): array;
}
