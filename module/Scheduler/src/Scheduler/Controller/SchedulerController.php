<?php
/**
 * Scheduler Module
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace Scheduler\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

use Scheduler\Entity\Event;
use Scheduler\Form\CreateEventForm;
use Scheduler\Form\UpdateEventForm;

class SchedulerController extends AbstractActionController
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

        // Quick check for form submission
        if ($request->isPost()) {
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
}
