<?php

namespace Geekhub\RequestSample\Api\Data;

/**
 * Request Sample interface.
 * @api
 */
interface RequestSampleInterface
{
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return RequestSampleInterface
     */
    public function setId($id);

    /**
     * Gets the created-at timestamp for the request sample.
     *
     * @return string|null Created-at timestamp.
     */
    public function getCreatedAt();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set name
     *
     * @param string $name
     * @return RequestSampleInterface
     */
    public function setName($name);

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set email
     *
     * @param string $email
     * @return RequestSampleInterface
     */
    public function setEmail($email);

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone();

    /**
     * Set phone
     *
     * @param string $phone
     * @return RequestSampleInterface
     */
    public function setPhone($phone);

    /**
     * Get Product Name
     *
     * @return string
     */
    public function getProductName();

    /**
     * Set Product Name
     *
     * @param string $productName
     * @return RequestSampleInterface
     */
    public function setProductName($productName);

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku();

    /**
     * Set sku
     *
     * @param string $sku
     * @return RequestSampleInterface
     */
    public function setSku($sku);

    /**
     * Get request
     *
     * @return string
     */
    public function getRequest();

    /**
     * Set request
     *
     * @param string $request
     * @return RequestSampleInterface
     */
    public function setRequest($request);

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param string $status
     * @return RequestSampleInterface
     */
    public function setStatus($status);

    /**
     * Get store ID
     *
     * @return string
     */
    public function getStoreId();

    /**
     * Set store ID
     *
     * @param int $storeId
     * @return RequestSampleInterface
     */
    public function setStoreId($storeId);

}
