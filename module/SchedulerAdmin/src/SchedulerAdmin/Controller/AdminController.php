<?php
/**
 * Scheduler Admin Module
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace SchedulerAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;

use Scheduler\Entity\Event;

class AdminController extends AbstractActionController
{
    /**
     * @var DoctrineORMEntityManager
     */
    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }

        return $this->em;
    }

    /**
     * List all events
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'events' => $this->getEntityManager()->getRepository('Scheduler\Entity\Event')->findAll(),
        ));
    }

    /**
     * Create an event
     */
    public function createAction()
    {
        // Get the ObjectManager
        $objectManager = $this->getEntityManager();

        // Create the form
        $form = new CreateEventForm($objectManager);
        $form->get('submit')->setValue('Create');

        // Create a new, empty entity and bind it to the form
        $event = new Event();
        $form->bind($event);

        // Load the request data
        $request = $this->getRequest();

        // Quick check for ajax submission
        if ($request->isXmlHttpRequest()) {
            // Get the fieldset (subform) identifier
            $fieldsetId = $request->getQuery('id', false);
            if (!$fieldsetId) {
                return new JsonModel(array(
                    'message' => 'Unknown fieldset',
                    'success' => false,
                ));
            }

            // Load the data
            $data = $request->getQuery();
            $form->setData($data);
            // Only validate current fieldset (subform)
            $validate = $this->_findValidationSet($data, $fieldsetId);
            $form->setValidationGroup($validate);

            // Validate subform
            if ($form->isValid()) {
                return new JsonModel(array(
                    'message' => 'Success',
                    'success' => true,
                ));
            } else {
                return new JsonModel(array(
                    'message' => 'Invalid form',
                    'errors'  => $form->getMessages(),
                    'validate' => $validate,
                    'success' => false,
                ));
            }

        // Quick check for form submission
        } elseif ($request->isPost()) {
            $form->setData($request->getPost());

            // Check for valid form
            if ($form->isValid()) {
                $objectManager->persist($event);
                $objectManager->flush();

                // Redirect to index
                return $this->redirect()->toRoute('scheduler');
            }
        }

        return array('form' => $form);
    }

    /**
     * Edit an event
     */
    public function editAction()
    {
        // Load the event id
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('scheduler', array(
                'action' => 'add',
            ));
        }

        // Get the ObjectManager
        $objectManager = $this->getEntityManager();

        // Find the entity
        $event = $objectManager->find('Scheduler\Entity\Event', $id);
        if (!$event) {
            return $this->redirect()->toRoute('scheduler', array(
                'action' => 'index',
            ));
        }

        // Create the form
        $form = new UpdateEventForm($objectManager);
        $form->get('submit')->setValue('Update');

        // Bind the entity to the form
        $form->bind($event);

        // Load the request data
        $request = $this->getRequest();

        // Quick check for form submission
        if ($request->isPost()) {
            $form->setData($request->getPost());

            // Check for valid form
            if ($form->isValid()) {
                $objectManager->flush();

                // Redirect to index
                return $this->redirect()->toRoute('scheduler');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    /**
     * Delete an event
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('scheduler');
        }

        // Get the ObjectManager
        $objectManager = $this->getEntityManager();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ('Yes' == $del) {
                $id = (int) $request->getPost('id');
                $appointment = $objectManager->find('Scheduler\Entity\Event', $id);
                if ($appointment) {
                    $objectManager->remove($appointment);
                    $objectManager->flush();
                }
            }

            return $this->redirect()->toRoute('scheduler');
        }

        return array(
            'id' => $id,
            'event' => $objectManager->find('Scheduler\Entity\Event', $id),
        );
    }

    protected function _findValidationSet($data, $fieldset)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($data),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $key => $value) {
            if ($key === $fieldset) {
                $return = array(
                    $key => array_keys(array_filter($value, function ($v) { return !is_array($v); })),
                );
                for ($i = $iterator->getDepth() - 1; $i >= 0; $i--) {
                    $return = array(
                        $iterator->getSubIterator($i)->key() => $return,
                    );
                }

                return $return;
            }
        }
    }
}
