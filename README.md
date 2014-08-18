# simpleflake-PHP

Distributed ID generation in PHP for the lazy. Based on the awesome [python implementation][simpleflake-py] from [SawdustSoftware][].

You can read an overview of what this does and why it came into being at the [Sawdust Software Blog][desc].

# Usage

    <?php
    
    use \simpleflake;
    
    $newId = \simpleflake\generate();
    echo "ID: $newId\n";
    
    $parts = \simpleflake\parse($newId);
    echo "Timestamp:  " . $parts["timestamp"] . "\n";
    echo "RandomBits: " . $parts["randomBits"] . "\n";
    

[desc]: http://engineering.custommade.com/simpleflake-distributed-id-generation-for-the-lazy/
[simpleflake-py]: https://github.com/SawdustSoftware/simpleflake
[SawdustSoftware]: http://sawdustsoftware.com/
  

