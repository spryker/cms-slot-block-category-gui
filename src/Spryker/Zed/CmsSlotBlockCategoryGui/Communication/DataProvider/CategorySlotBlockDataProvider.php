<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockCategoryGui\Communication\DataProvider;

use Generated\Shared\Transfer\CategoryCollectionTransfer;
use Generated\Shared\Transfer\CategoryCriteriaTransfer;
use Generated\Shared\Transfer\CategoryTransfer;
use Spryker\Zed\CmsSlotBlockCategoryGui\Communication\Form\CategorySlotBlockConditionForm;
use Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToCategoryFacadeInterface;
use Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToLocaleFacadeInterface;
use Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToTranslatorFacadeInterface;

class CategorySlotBlockDataProvider implements CategorySlotBlockDataProviderInterface
{
    /**
     * @var string
     */
    protected const KEY_OPTION_ALL_CATEGORIES = 'All Category Pages';

    /**
     * @var string
     */
    protected const KEY_OPTION_SPECIFIC_CATEGORY = 'Specific Category Pages';

    /**
     * @var string
     */
    protected const FORMATTED_CATEGORY_NAME = '%s [%s]';

    /**
     * @var \Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToCategoryFacadeInterface
     */
    protected $categoryFacade;

    /**
     * @var \Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToLocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @var \Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToTranslatorFacadeInterface
     */
    protected $translatorFacade;

    /**
     * @var array<int>|null
     */
    protected static $categoryCache = null;

    /**
     * @param \Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToCategoryFacadeInterface $categoryFacade
     * @param \Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToLocaleFacadeInterface $localeFacade
     * @param \Spryker\Zed\CmsSlotBlockCategoryGui\Dependency\Facade\CmsSlotBlockCategoryGuiToTranslatorFacadeInterface $translatorFacade
     */
    public function __construct(
        CmsSlotBlockCategoryGuiToCategoryFacadeInterface $categoryFacade,
        CmsSlotBlockCategoryGuiToLocaleFacadeInterface $localeFacade,
        CmsSlotBlockCategoryGuiToTranslatorFacadeInterface $translatorFacade
    ) {
        $this->categoryFacade = $categoryFacade;
        $this->localeFacade = $localeFacade;
        $this->translatorFacade = $translatorFacade;
    }

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return [
            CategorySlotBlockConditionForm::OPTION_ALL_ARRAY => $this->getAllOptions(),
            CategorySlotBlockConditionForm::OPTION_CATEGORY_ARRAY => $this->getCategories(),
        ];
    }

    /**
     * @return array
     */
    protected function getAllOptions(): array
    {
        return [
            $this->translatorFacade->trans(static::KEY_OPTION_ALL_CATEGORIES) => true,
            $this->translatorFacade->trans(static::KEY_OPTION_SPECIFIC_CATEGORY) => false,
        ];
    }

    /**
     * @return array<int>
     */
    protected function getCategories(): array
    {
        if (static::$categoryCache !== null) {
            return static::$categoryCache;
        }

        $categoryCriteriaTransfer = (new CategoryCriteriaTransfer())
            ->setIdLocale($this->localeFacade->getCurrentLocale()->getIdLocale());

        static::$categoryCache = $this->getCategoryIdsFromCollection(
            $this->categoryFacade->getCategoriesByCriteria($categoryCriteriaTransfer),
        );

        return static::$categoryCache;
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryCollectionTransfer $categoryCollectionTransfer
     *
     * @return array<int>
     */
    protected function getCategoryIdsFromCollection(CategoryCollectionTransfer $categoryCollectionTransfer): array
    {
        $categoryIds = [];
        foreach ($categoryCollectionTransfer->getCategories() as $categoryTransfer) {
            $categoryIds[$this->getFormattedCategoryName($categoryTransfer)] = $categoryTransfer->getIdCategory();
        }

        return $categoryIds;
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryTransfer $categoryTransfer
     *
     * @return string
     */
    protected function getFormattedCategoryName(CategoryTransfer $categoryTransfer): string
    {
        return sprintf(static::FORMATTED_CATEGORY_NAME, $categoryTransfer->getName(), $categoryTransfer->getCategoryKey());
    }
}
