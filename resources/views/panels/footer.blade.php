<footer class="footer footer-light @if(isset($configData['footerType'])){{$configData['footerClass']}}@endif">
  <p class="clearfix mb-0">
    <span class="float-left d-inline-block"><script>document.write(new Date().getFullYear())</script> &copy; <a href="https://www.instagram.com/danuzioferreira" target="_blank"><strong>Danúzio Ferreira</strong></a> | Todos os direitos reservados.</span>
    <span class="float-right d-sm-inline-block d-none">
      Desenvolvido com ☕ e 🍺 em São Luís (MA)
    </span>
  </p>
  @if($configData['isScrollTop'] === true)
  <button class="btn btn-primary btn-icon scroll-top" type="button" style="display: inline-block;">
  <i class="bx bx-up-arrow-alt"></i>
  </button>
  @endif
</footer>

