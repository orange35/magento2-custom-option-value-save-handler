<?php

namespace Orange35\CustomOptionValueSaveHandler;

class CatalogModelProductOptionValue
{
    public function aroundSaveValues(\Magento\Catalog\Model\Product\Option\Value $subject, \Closure $proceed)
    {
        foreach ($subject->getValues() as $value) {
            $clone = clone $subject;
            $clone->setData(
                $value
            )->setData(
                'option_id',
                $clone->getOption()->getId()
            )->setData(
                'store_id',
                $clone->getOption()->getStoreId()
            );

            if ($clone->getData('is_delete') == '1') {
                if ($clone->getId()) {
                    $clone->deleteValues($clone->getId());
                    $clone->delete();
                }
            } else {
                $clone->save();
            }
        }
        return $subject;
    }
}
