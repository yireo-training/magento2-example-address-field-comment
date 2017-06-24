<?php
namespace Yireo\ExampleAddressFieldComment\Plugin;

use Magento\Customer\Block\Address\Edit as Subject;
use Magento\Framework\View\Element\Template;
use Yireo\ExampleAddressFieldComment\Block\Address\Edit\Field\Comment as CommentBlock;

/**
 * Class AddCommentFieldToAddressForm
 *
 * @package Yireo\ExampleAddressFieldComment\Plugin
 */
class AddCommentFieldToAddressForm
{
    /**
     * @param Subject $subject
     * @param string $html
     *
     * @return string
     */
    public function afterToHtml(Subject $subject, string $html) : string
    {
        $commentBlock = $this->getChildBlock(CommentBlock::class, $subject);
        $commentBlock->setAddress($subject->getAddress());
        $html = $this->appendBlockBeforeFieldsetEnd($html, $commentBlock->toHtml());

        return $html;
    }

    /**
     * @param string $html
     * @param string $childHtml
     *
     * @return string
     */
    private function appendBlockBeforeFieldsetEnd(string $html, string $childHtml) : string
    {
        $pregMatch = '/\<\/fieldset\>/';
        $pregReplace = $childHtml . '\0';
        $html = preg_replace($pregMatch, $pregReplace, $html, 1);

        return $html;
    }

    /**
     * @param string $blockClass
     * @param Template $parentBlock
     *
     * @return mixed
     */
    private function getChildBlock(string $blockClass, Template $parentBlock)
    {
        $blockId = str_replace('\\', '_', $blockClass);
        return $parentBlock->getLayout()->createBlock($blockClass, $blockId);
    }
}