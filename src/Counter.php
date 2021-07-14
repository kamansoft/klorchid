<?php

namespace Kamansoft\Klorchid;

class Counter
{

    private int $parts = 10;
    private float $step = 1;
    private float $end;
    private float $mark_interval;
    private float $mark;
    private float $count = 1;

    public function __construct(float $end, ?float $start = null, ?float $step = null, ?int $parts = null)
    {
        $this->parts = is_null($parts) ? $this->parts : $parts;
        $this->step = is_null($step) ? $this->step : $step;
        $this->end = $end;
        $this->mark_interval = $this->end / $this->parts;
        $this->setMark();
        $this->count = is_null($start) ? $this->count : $start;
        /*echo '
         ' . $this->parts . '
         ' . $this->step . '
         ' . $this->end . '
         ' . $this->mark_interval . '
         ' . $this->mark . '
         ' . $this->count;*/
    }


    public function setMark()
    {
        if (!isset($this->mark)) {
            $this->mark = $this->mark_interval;
        } else //if ($this->count > $this->mark) {
        {
            $this->mark = $this->mark + $this->mark_interval;
        }
        return $this;
    }

    public function count()
    {
        //$this->setMark();
        $this->count = $this->count + $this->step;




        return $this;
    }
    public function show()
    {
        /*echo '
        ' . $this->mark . '
        ' . $this->count;*/
        if (($this->count > $this->mark) or $this->count == $this->end) {
            $this->setMark();
            echo '
' . $this->count . ' of ' . $this->end;
        }
        return $this;
    }
}
