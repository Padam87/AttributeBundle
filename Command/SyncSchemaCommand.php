<?php

namespace Padam87\AttributeBundle\Command;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Padam87\AttributeBundle\Entity\Schema;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncSchemaCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('eav:schema:sync')
            ->setDescription('Syncs the existing schemas in the database with the current metadata')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reader = new AnnotationReader();
        /** @var ManagerRegistry $doctrine */
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();
        $cmf = $em->getMetadataFactory();

        $existing = [];
        $created = [];

        /** @var ClassMetadata $metadata */
        foreach ($cmf->getAllMetadata() as $metadata) {
            $refl = $metadata->getReflectionClass();

            if ($refl === null) {
                $refl = new \ReflectionClass($metadata->getName());
            }

            if ($reader->getClassAnnotation($refl, 'Padam87\AttributeBundle\Annotation\Entity') != null) {
                $schema = $em->getRepository('Padam87AttributeBundle:Schema')->findOneBy([
                    'className' => $metadata->getName(),
                ]);

                if ($schema === null) {
                    $schema = new Schema();
                    $schema->setClassName($metadata->getName());

                    $em->persist($schema);
                    $em->flush($schema);

                    $created[] = $metadata->getName();
                } else {
                    $existing[] = $metadata->getName();
                }
            }
        }

        $table = new Table($output);

        $table->addRow(['Created:', implode(PHP_EOL, $created)]);
        $table->addRow(new TableSeparator());
        $table->addRow(['Existing:', implode(PHP_EOL, $existing)]);

        $table->render();
    }
}
