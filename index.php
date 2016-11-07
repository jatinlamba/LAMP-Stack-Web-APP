<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$bucket ='raw-jal';
$keyname = 'switchonarex.png';

// $filepath should be absolute path to a file on disk
$filepath = '/jlamba1/switchonarex.png';

// Instantiate the client.
$s3 = S3Client::factory(array(

    'credentials' => array(
    'key'    => 'AKIAIOWQFOCIR4RW633A',
    'secret' => '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'),
    'version' => 'latest',
    'region'  => 'us-west-2'
));

try {
    // Upload data.
    $result = $s3->putObject(array(
        'Bucket' => $bucket,
        'Key'    => $keyname,
        'SourceFile'   => $filepath,
        'ContentType' => 'image/png',
        'ACL'    => 'public-read'
    ));



    // Print the URL to the object.
    echo $result['ObjectURL'] . "\n";
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}

?>
