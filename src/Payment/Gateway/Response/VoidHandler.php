<?php
/**
 * Copyright 2016 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Amazon\Payment\Gateway\Response;

use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Payment\Model\Method\Logger;
use Amazon\Payment\Gateway\Helper\SubjectReader;
use Magento\Framework\Message\ManagerInterface;

class VoidHandler implements HandlerInterface
{

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var SubjectReader
     */
    private $subjectReader;


    /**
     * RefundHandler constructor.
     *
     * @param Logger         $logger
     * @param SubjectReader  $subjectReader
     * @param $messageManager
     */
    public function __construct(
        Logger $logger,
        SubjectReader $subjectReader,
        ManagerInterface $messageManager
    ) {
        $this->logger = $logger;
        $this->subjectReader = $subjectReader;
        $this->messageManager = $messageManager;
    }

    /**
     * @param array $handlingSubject
     * @param array $response
     */
    public function handle(array $handlingSubject, array $response)
    {
        if (isset($response['status']) && !$response['status']) {
            $this->messageManager->addErrorMessage(
                __('Unable to cancel the order or the Amazon Order ID is incorrect.')
            );
        } else {
            $this->messageManager->addSuccessMessage(__('Successfully cancelled Amazon Pay.'));
        }
    }
}
