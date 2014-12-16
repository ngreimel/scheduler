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
use Scheduler\Entity\Appointment;
use Scheduler\Form\AppointmentForm;
use Doctrine\ORM\EntityManager;

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

    public function indexAction()
    {
        return new ViewModel(array(
            'appointments' => $this->getEntityManager()->getRepository('Scheduler\Entity\Appointment')->findAll(),
        ));
    }

    public function addAction()
    {
        $form = new AppointmentForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $appointment = new Appointment();
            $form->setInputFilter($appointment->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $appointment->exchangeArray($form->getData());
                $this->getEntityManager()->persist($appointment);
                $this->getEntityManager()->flush();

                // Redirect to index
                return $this->redirect()->toRoute('scheduler');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('scheduler', array(
                'action' => 'add',
            ));
        }

        $appointment = $this->getEntityManager()->find('Scheduler\Entity\Appointment', $id);
        if (!$appointment) {
            return $this->redirect()->toRoute('scheduler', array(
                'action' => 'index',
            ));
        }

        $form = new AppointmentForm();
        $form->bind($appointment);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($appointment->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEntityManager()->flush();

                return $this->redirect()->toRoute('scheduler');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('scheduler');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ('Yes' == $del) {
                $id = (int) $request->getPost('id');
                $appointment = $this->getEntityManager()->find('Scheduler\Entity\Appointment', $id);
                if ($appointment) {
                    $this->getEntityManager()->remove($appointment);
                    $this->getEntityManager()->flush();
                }
            }

            return $this->redirect()->toRoute('scheduler');
        }

        return array(
            'id' => $id,
            'appointment' => $this->getEntityManager()->find('Scheduler\Entity\Appointment', $id),
        );
    }
}
