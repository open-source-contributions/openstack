<?php

namespace OpenStack\Identity\v3\Models;

use OpenCloud\Common\Resource\AbstractResource;
use OpenCloud\Common\Resource\Creatable;
use OpenCloud\Common\Resource\Deletable;
use OpenCloud\Common\Resource\Listable;
use OpenCloud\Common\Resource\Retrievable;
use OpenCloud\Common\Resource\Updateable;

/**
 * @property \OpenStack\Identity\v3\Api $api
 */
class User extends AbstractResource implements Creatable, Listable, Retrievable, Updateable, Deletable
{
    /** @var string */
    public $domainId;

    /** @var string */
    public $defaultProjectId;

    /** @var string */
    public $id;

    /** @var string */
    public $email;

    /** @var bool */
    public $enabled;

    /** @var string */
    public $description;

    /** @var array */
    public $links;

    /** @var string */
    public $name;

    protected $aliases = [
        'domain_id'          => 'domainId',
        'default_project_id' => 'defaultProjectId'
    ];

    protected $resourceKey = 'user';
    protected $resourcesKey = 'users';

    /**
     * {@inheritDoc}
     *
     * @param array $data {@see \OpenStack\Identity\v3\Api::postUsers}
     */
    public function create(array $data)
    {
        $response = $this->execute($this->api->postUsers(), $data);
        return $this->populateFromResponse($response);
    }

    /**
     * {@inheritDoc}
     */
    public function retrieve()
    {
        $response = $this->execute($this->api->getUser(), ['id' => $this->id]);
        return $this->populateFromResponse($response);
    }

    /**
     * {@inheritDoc}
     */
    public function update()
    {
        $response = $this->executeWithState($this->api->patchUser());
        return $this->populateFromResponse($response);
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        $this->execute($this->api->deleteUser(), ['id' => $this->id]);
    }

    /**
     * @return \Generator
     */
    public function listGroups()
    {
        $options['id'] = $this->id;
        return $this->model(Group::class)->enumerate($this->api->getUserGroups(), $options);
    }

    /**
     * @return \Generator
     */
    public function listProjects()
    {
        return $this->model(Project::class)->enumerate($this->api->getUserProjects(), ['id' => $this->id]);
    }
}
