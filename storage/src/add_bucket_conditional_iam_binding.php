<?php
/**
 * Copyright 2020 Google Inc.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/storage/README.md
 */

namespace Google\Cloud\Samples\Storage;

# [START storage_add_bucket_conditional_iam_binding]
use Google\Cloud\Storage\StorageClient;

/**
 * Adds a conditional IAM binding to a bucket's IAM policy.
 *
 * @param string $bucketName The name of your Cloud Storage bucket.
 * @param string $role The role that will be given to members in this binding.
 * @param string[] $members The member(s) associated with this binding.
 * @param string $title The title of the condition.
 * @param string $description The description of the condition.
 * @param string $expression The condition specified in CEL expression language.
 *
 * To see how to express a condition in CEL, visit:
 * @see https://cloud.google.com/storage/docs/access-control/iam#conditions.
 */
function add_bucket_conditional_iam_binding($bucketName, $role, array $members, $title, $description, $expression)
{
    // $bucketName = 'my-bucket';
    // $role = 'roles/storage.objectViewer';
    // $members = ['group:example@google.com'];
    // $title = 'Title';
    // $description = 'Condition Description';
    // $expression = 'resource.name.startsWith("projects/_/buckets/bucket-name/objects/prefix-a-")';

    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);

    $policy = $bucket->iam()->policy(['requestedPolicyVersion' => 3]);

    $policy['version'] = 3;

    $policy['bindings'][] = [
        'role' => $role,
        'members' => $members,
        'condition' => [
            'title' => $title,
            'description' => $description,
            'expression' => $expression,
        ],
    ];

    $bucket->iam()->setPolicy($policy);

    printf('Added the following member(s) with role %s to %s:' . PHP_EOL, $role, $bucketName);
    foreach ($members as $member) {
        printf('    %s' . PHP_EOL, $member);
    }
    printf('with condition:' . PHP_EOL);
    printf('    Title: %s' . PHP_EOL, $title);
    printf('    Description: %s' . PHP_EOL, $description);
    printf('    Expression: %s' . PHP_EOL, $expression);
}
# [END storage_add_bucket_conditional_iam_binding]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
