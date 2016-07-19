<?php
/**
 * @link      http://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   http://craftcms.com/license
 */

namespace craft\app\models;

use Craft;

/**
 * Class EntryDraft model.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  3.0
 */
class EntryDraft extends BaseEntryRevisionModel
{
    // Static
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function populateModel($model, $config)
    {
        /** @var static $model */
        // Merge the draft and entry data
        $entryData = $config['data'];
        $fieldContent = isset($entryData['fields']) ? $entryData['fields'] : null;
        $config['draftId'] = $config['id'];
        $config['id'] = $config['entryId'];
        $config['revisionNotes'] = $config['notes'];
        $title = $entryData['title'];
        unset($config['data'], $entryData['fields'], $config['entryId'], $config['notes'], $entryData['title']);
        $config = array_merge($config, $entryData);

        parent::populateModel($model, $config);

        // Use the live content as a starting point
        Craft::$app->getContent()->populateElementContent($model);

        if ($title) {
            $model->title = $title;
        }

        if ($fieldContent) {
            $model->setContentFromRevision($fieldContent);
        }
    }

    // Properties
    // =========================================================================

    /**
     * @var integer Draft ID
     */
    public $draftId;

    /**
     * @var string Name
     */
    public $name;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [['locale'], 'craft\\app\\validators\\Locale'],
            [['dateCreated'], 'craft\\app\\validators\\DateTime'],
            [['dateUpdated'], 'craft\\app\\validators\\DateTime'],
            [
                ['root'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [
                ['lft'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [
                ['rgt'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [
                ['level'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [
                ['sectionId'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [
                ['typeId'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [
                ['authorId'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [['postDate'], 'craft\\app\\validators\\DateTime'],
            [['expiryDate'], 'craft\\app\\validators\\DateTime'],
            [
                ['newParentId'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [
                ['creatorId'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [
                ['draftId'],
                'number',
                'min' => -2147483648,
                'max' => 2147483647,
                'integerOnly' => true
            ],
            [
                [
                    'id',
                    'enabled',
                    'archived',
                    'locale',
                    'localeEnabled',
                    'slug',
                    'uri',
                    'dateCreated',
                    'dateUpdated',
                    'root',
                    'lft',
                    'rgt',
                    'level',
                    'sectionId',
                    'typeId',
                    'authorId',
                    'postDate',
                    'expiryDate',
                    'newParentId',
                    'revisionNotes',
                    'creatorId',
                    'draftId',
                    'name'
                ],
                'safe',
                'on' => 'search'
            ],
        ];
    }
}