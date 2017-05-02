<option value="" selected="selected">Select One...</option>
<?php

foreach (us_states() as $key => $val) {
  echo '<option value="' . $key . '">' . $val . '</option>';
}
