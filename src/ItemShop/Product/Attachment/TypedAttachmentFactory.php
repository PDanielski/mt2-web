<?php


namespace App\ItemShop\Product\Attachment;


class TypedAttachmentFactory implements TypedAttachmentFactoryInterface {

    /** @var TypedAttachmentRepositoryInterface[] */
    protected $registry;

    /**
     * TypedAttachmentFactory constructor.
     * @param TypedAttachmentRepositoryInterface[] $typedAttachmentRepositories
     */
    public function __construct(array $typedAttachmentRepositories) {
        foreach($typedAttachmentRepositories as $repository) {
            if(!$repository instanceof TypedAttachmentRepositoryInterface)
                throw new \RuntimeException("There repositories must implement the TypedAttachmentRepositoryInterface");
            $this->registry[$repository->getType()] = $repository;
        }
    }

    public function create(int $attachmentId, string $attachmentType): AttachmentInterface {
        if(isset($this->registry[$attachmentType])) {
            return $this->registry[$attachmentType]->getById($attachmentId);
        }
        throw new \RuntimeException("The type {$attachmentType} is not registered");
    }

}