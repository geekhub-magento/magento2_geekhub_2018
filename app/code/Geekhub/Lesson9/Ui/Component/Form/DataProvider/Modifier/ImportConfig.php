<?php
namespace Geekhub\Lesson9\Ui\Component\Form\DataProvider\Modifier;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class ImportConfig implements ModifierInterface
{
    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * ImportConfig constructor.
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        ArrayManager $arrayManager
    ) {
        $this->arrayManager = $arrayManager;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        /**
         * Try imports, exports, links
         */
        $config = [
            'imports' => [
                'value' => '${$.parentName}.job_code:value'
            ]
        ];
        $path = $this->arrayManager->findPath('custom_field', $meta);
        $meta = $this->arrayManager->merge($path . '/arguments/data/config', $meta, $config);

        return $meta;
    }
}
