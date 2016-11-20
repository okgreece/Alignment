<script>
    $(function () {
        $(".dial").knob({
            'min': 0,
            'max': 100,
            'step': 1,
            'width': 150

        });
    });
</script>
<label for="minC1">Min Confidence</label>
<input type="checkbox" name="checkMinC1" value="true" >
<input class="dial" type="text" name="minC1" value="50">
<label for="maxC1">Max Confidence</label>
<input type="checkbox" name="checkMaxC1" value="true">
<input class="dial" type="text" name="maxC1" value="100">
