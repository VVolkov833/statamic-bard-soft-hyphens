<?php

namespace Kabocom\SoftHyphens;

\Log::info('Bard is loaded');

class Bard extends \Statamic\Fieldtypes\Bard
{

    /* modify to print in the editor */
    public function preProcess($value)
    {
        \Log::info('Bard is processed');
        if (is_array($value)) {
            $value = $this->replaceInBardContent($value, '­', '↵'); // ↵↩↴⤦⤶⤸
        }

        return parent::preProcess($value);
    }

    /* modify to save in .md */
    public function process($value)
    {
        if (is_array($value)) {
            $value = $this->replaceInBardContent($value, '↵', '­');
        }

        return parent::process($value);
    }

    /**
     * Recursively replace text in Bard content.
     *
     * @param array $content
     * @param string $search
     * @param string $replace
     * @return array
     */
    private function replaceInBardContent(array $content, string $search, string $replace): array
    {
        foreach ($content as &$node) {
            // Check if the node has a `text` attribute and replace the value
            if (isset($node['text'])) {
                //\Log::info($node['text']);
                $node['text'] = str_replace($search, $replace, $node['text']);
            }

            // Check if the node has a `content` attribute and recurse into it
            if (isset($node['content']) && is_array($node['content'])) {
                $node['content'] = $this->replaceInBardContent($node['content'], $search, $replace);
            }
        }

        return $content;
    }
}
