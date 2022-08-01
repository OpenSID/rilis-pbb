<script>
    // This is an old version, for a more recent version look at
    // https://jsfiddle.net/DRSDavidSoft/zb4ft1qq/2/
    function maxLengthCheck(object)
    {
      if (object.value.length > object.maxLength)
        object.value = object.value.slice(0, object.maxLength)
    }
</script>
