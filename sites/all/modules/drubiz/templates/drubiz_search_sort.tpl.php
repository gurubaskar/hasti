<select id="search_sort">
  <option value="">- Choose -</option>
  <!-- <option value="totalQuantityOrdered-desc">Best Selling</option>
  <option value="introductionDate-desc">New Arrivals</option> -->
  <option value="fss_field_price desc" <?php echo @$_GET['solrsort'] == 'fss_field_price desc' ? 'selected="selected"' : ''; ?>>Price High to Low</option>
  <option value="fss_field_price asc" <?php echo @$_GET['solrsort'] == 'fss_field_price asc' ? 'selected="selected"' : ''; ?>>Price Low to High</option>
  <option value="fss_field_discount desc" <?php echo @$_GET['solrsort'] == 'fss_field_discount desc' ? 'selected="selected"' : ''; ?>>Discount High to Low</option>
  <option value="fss_field_discount asc" <?php echo @$_GET['solrsort'] == 'fss_field_discount asc' ? 'selected="selected"' : ''; ?>>Discount Low to High</option>
</select>
