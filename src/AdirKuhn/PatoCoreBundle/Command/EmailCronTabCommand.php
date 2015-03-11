<?php

namespace AdirKuhn\PatoCoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\StringInput;

class EmailCronTabCommand extends ContainerAwareCommand
{
    private $output;

    protected function configure()
    {
        $this->setName('patocron:emails');
        $this->setDescription('Cron to send emails');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Running Cron...</comment>');

        $output->writeln('<comment>Getting overdue accounts...</comment>');

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $overDueAccountsReceivable = $em->getRepository('CashFlowBundle:Accounts')->getOverdueAccounts(0);
        $overDueAccountsPayable = $em->getRepository('CashFlowBundle:Accounts')->getOverdueAccounts(1);

        $output->writeln('<comment>Generating templates...</comment>');


        $output->writeln('<comment>Getting mailer...</comment>');
        $twig = $this->getContainer()->get('templating');
        $mailer = $this->getContainer()->get('swiftmailer.mailer');

        var_dump($twig->render(
            'PatoCoreBundle:Default:overduemail.html.twig',
            array('overDueAccountsReceivable' => $overDueAccountsReceivable)
        ));die('hmm');

        $message = $mailer->createMessage()
            ->setSubject('Contas vencidas!')
            ->setFrom('adirkuhn@gmail.com')
            ->setTo('adirkuhn@gmail.com')
            ->setContentType('text/html')
            ->setBody(
                $twig->render(
                    'PatoCoreBundle:Default:overduemail.html.twig',
                    array('overDueAccountsReceivable' => $overDueAccountsReceivable)
                )
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;


        $output->writeln('<comment>Sending message...</comment>');
        try {
            $mailer->send($message);
        } catch (\Exception $e) {
            $output->writeln('<error>Send error.</error>');
        }
    }
}