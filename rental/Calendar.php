<?php
//TODO:namespaceの役割理解


class Calendar {
  public $prev;
  public $next;
  public $yearMonth;
  private $_thisMonth;

  public function __construct() {
    try {
      if (!isset($_GET['t']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['t'])) {
        throw new \Exception();
      }
      $this->_thisMonth = new \DateTime($_GET['t']);
    } catch (\Exception $e) {
      $this->_thisMonth = new \DateTime('first day of this month');
    }
    $this->prev = $this->_createPrevLink();
    $this->next = $this->_createNextLink();
    $this->yearMonth = $this->_thisMonth->format('F Y');
  }

  private function _createPrevLink() {
    $dt = clone $this->_thisMonth;
    return $dt->modify('-1 month')->format('Y-m');
  }

  private function _createNextLink() {
    $dt = clone $this->_thisMonth;
    return $dt->modify('+1 month')->format('Y-m');
  }

    public function show($id, $exhibit) {
        $id = $id;
        $tail = $this->_getTail();
        $body = $this->_getBody($id, $exhibit);
        $head = $this->_getHead();
        $html = '<tr>' . $tail . $body . $head . '</tr>';
        echo $html;
    }

    private function _getTail() {
        $tail = '';
        $lastDayOfPrevMonth = new \DateTime('last day of ' . $this->yearMonth . ' -1 month');
        while ($lastDayOfPrevMonth->format('w') < 6) {
            $tail = sprintf('<td class="gray">%d</td>', $lastDayOfPrevMonth->format('d')) . $tail;
            $lastDayOfPrevMonth->sub(new \DateInterval('P1D'));
        }
        return $tail;
    }

    private function _getBody($id, $exhibit) {
        $id = $id;
        $reservedDays = $exhibit->getReservations($id);
        $body = '';
        $period = new \DatePeriod(
            new \DateTime('first day of ' . $this->yearMonth),
            new \DateInterval('P1D'),
            new \DateTime('first day of ' . $this->yearMonth . ' +1 month')
        );
        $today = new \DateTime('today');

        foreach ($period as $day) {
            if ($day->format('w') === '0') { $body .= '</tr><tr>'; }
            $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';
            if(in_array($day->format('Y-m-d'),$reservedDays)){
                $color = 'gray';
                $check = 'hidden';
                $name  = 'hidden';
//          TODO:hiddenじゃなくてcssで消す
            }else{
                $color = 'black';
                $check = 'checkbox';
                $name  = 'day[]';
            }
            $tmp = $day->format('Y-m-d');
            $body .= sprintf("<td class='$color'><input type='$check'  name='$name' value='$tmp'>%d</td>", $day->format('d'));


        }
        return $body;
    }

    private function _getHead() {
        $head = '';
        $firstDayOfNextMonth = new \DateTime('first day of ' . $this->yearMonth . ' +1 month');
        while ($firstDayOfNextMonth->format('w') > 0) {
            $head .= sprintf('<td class="gray">%d</td>', $firstDayOfNextMonth->format('d'));
            $firstDayOfNextMonth->add(new \DateInterval('P1D'));
        }
        return $head;
    }

}