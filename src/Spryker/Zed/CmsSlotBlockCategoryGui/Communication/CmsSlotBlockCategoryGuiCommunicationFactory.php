<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockCategoryGui\Communication;

use Spryker\Zed\CmsSlotBlockCategoryGui\CmsSlotBlockCategoryGuiDependencyProvider;
use Spryker\Zed\CmsSlotBlockCategoryGui\Communication\DataProvider\CategorySlotBlockDataProvider;
use Spryker\Zed\CmsSlotBlockCategoryGui\Communication\DataProvider\CategorySlotBlockDataProviderInterface;
use Spryker\Zed\CmsSlotBlockCategoryGui\Communication\Form\CategorySlotBlockConditionForm;
use Spryker\Zed\CmsSlotBlockCategoryGui\Communication\Form\Validator\Constraints\CategoryConditionConstraint;
use Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToCategoryFacadeInterface;
use Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToLocaleFacadeInterface;
use Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToTranslatorFacadeInterface;
use Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Service\CmsSlotBlockCategoryGuiToUtilEncodingInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CmsSlotBlockCategoryGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createCategorySlotBlockConditionForm(): CategorySlotBlockConditionForm
    {
        return new CategorySlotBlockConditionForm();
    }

    public function createCategorySlotBlockDataProvider(): CategorySlotBlockDataProviderInterface
    {
        return new CategorySlotBlockDataProvider(
            $this->getCategoryFacade(),
            $this->getLocaleFacade(),
            $this->getTranslatorFacade(),
        );
    }

    public function createCategoryConditionsConstraint(): CategoryConditionConstraint
    {
        return new CategoryConditionConstraint();
    }

    public function getCategoryFacade(): CmsSlotBlockCategoryGuiToCategoryFacadeInterface
    {
        return $this->getProvidedDependency(CmsSlotBlockCategoryGuiDependencyProvider::FACADE_CATEGORY);
    }

    public function getLocaleFacade(): CmsSlotBlockCategoryGuiToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(CmsSlotBlockCategoryGuiDependencyProvider::FACADE_LOCALE);
    }

    public function getTranslatorFacade(): CmsSlotBlockCategoryGuiToTranslatorFacadeInterface
    {
        return $this->getProvidedDependency(CmsSlotBlockCategoryGuiDependencyProvider::FACADE_TRANSLATOR);
    }

    public function getUtilEncoding(): CmsSlotBlockCategoryGuiToUtilEncodingInterface
    {
        return $this->getProvidedDependency(CmsSlotBlockCategoryGuiDependencyProvider::SERVICE_UTIL_ENCODING);
    }
}
