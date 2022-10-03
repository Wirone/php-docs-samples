<?php
/**
 * Copyright 2020 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/storage/README.md
 */

namespace Google\Cloud\Samples\Storage;

# [START storage_enable_bucket_lifecycle_management]
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\Bucket;

/**
 * Enable bucket lifecycle management.
 *
 * @param string $bucketName The name of your Cloud Storage bucket.
 */
function enable_bucket_lifecycle_management(string $bucketName): void
{
    // $bucketName = 'my-bucket';

    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);

    $lifecycle = Bucket::lifecycle()
        ->addDeleteRule([
            'age' => 100
        ]);

    $bucket->update([
        'lifecycle' => $lifecycle
    ]);

    $lifecycle = $bucket->currentLifecycle();

    printf('Lifecycle management is enabled for bucket %s and the rules are:' . PHP_EOL, $bucketName);
    foreach ($lifecycle as $rule) {
        print_r($rule);
        print(PHP_EOL);
    }
}
# [END storage_enable_bucket_lifecycle_management]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
