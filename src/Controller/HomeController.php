<?php


namespace App\Controller;


use App\Entity\Invoice;
use App\Entity\InvoiceLine;
use App\Form\InvoiceLineType;
use App\Form\InvoiceType;
use App\Repository\InvoiceLineRepository;
use App\Repository\InvoiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, InvoiceLineRepository $invoiceLineRepository, InvoiceRepository $invoiceRepository): Response
    {
        $invoiceLine = new InvoiceLine();
        $invoice = new  Invoice();
        $form = $this->createForm(InvoiceLineType::class, $invoiceLine);
        $form->handleRequest($request);
        $form2 = $this->createForm(InvoiceType::class, $invoice);
        $form2->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid()) {
            $invoiceLineRepository->add($invoiceLine);
            $invoiceRepository->add($invoice);
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('home.html.twig', [
            'invoice_line' => $invoiceLine,
            'invoice' => $invoice,
            'form' => $form,
            'form2' => $form2,
        ]);
    }

  /*  #[Route('/new', name: 'app_invoice_line_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InvoiceLineRepository $invoiceLineRepository): Response
    {
        $invoiceLine = new InvoiceLine();
        $form = $this->createForm(InvoiceLineType::class, $invoiceLine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoiceLineRepository->add($invoiceLine);
            return $this->redirectToRoute('app_invoice_line_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('invoice_line/new.html.twig', [
            'invoice_line' => $invoiceLine,
            'form' => $form,
        ]);
    }*/

}