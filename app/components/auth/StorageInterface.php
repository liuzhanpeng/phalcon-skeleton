<?php
namespace App\Components\Auth;

/**
 * 身份存储接口
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
interface StorageInterface
{
    /**
     * 保存身份
     * @param IdentityInterface $identity 身份信息
     */
    public function setIdentity(IdentityInterface $identity);

    /**
     * 返回身份
     * @return IdentityInterface | null
     */
    public function getIdentity(): ?IdentityInterface;

    // /**
    //  * 是否存在身份
    //  * @return bool
    //  */
    // public function hasIdentity(): bool;

    /**
     * 清除身份
     */
    public function removeIdentity();
}
