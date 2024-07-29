import { Suspense } from "react"
import { Loader } from "@mantine/core"

import { HoverEffect } from "@/components/ui/card-hover-effect"
import Footer from "@/components/landing-page/footer"
import { GetInTouch } from "@/components/landing-page/get-in-touch"
import { Header } from "@/components/landing-page/header"
import { HeroSection } from "@/components/landing-page/hero"
import Partners from "@/components/landing-page/partners"
import Pricing from "@/components/landing-page/pricing"
import Status from "@/components/landing-page/status"
import ZoomFeature from "@/components/landing-page/zoom-feature"

const projects = [
  {
    title: "إدارة العقارات والمرافق",
    src: "https://simaat.app/wp-content/uploads/2022/11/buildings.png",
    description:
      "تحول رقميًا بأتمتة جميع عمليات إدارة وتشغيل الأملاك والمرافق العقارية بحلول تقنية متكاملة تعزز من استدامة أعمالك وتسرعها، وتزيد من كفائتك وتخفض تكالفيك إلى النصف.",
  },
  {
    title: "طلبات صيانة آلية",
    src: "https://simaat.app/wp-content/uploads/2022/11/buildings.png",
    description:
      "قم بإجراء طلبات الصيانة العقارية آليًا، وتابع إنجازها في وقت قياسي بعد بإسنادها للمختصين (موظفين –مقاولين) مع ضمان تنفيذ طلب الصيانة برمز تأكيد الجودة.",
  },
  {
    title: "توثيق المعاملات المالية بين التجعات العقارية  ",
    src: "https://simaat.app/wp-content/uploads/2022/11/buildings.png",
    description:
      "قم بإجراء طلبات الصيانة العقارية آليًا، وتابع إنجازها في وقت قياسي بعد بإسنادها للمختصين (موظفين –مقاولين) مع ضمان تنفيذ طلب الصيانة برمز تأكيد الجودة.",
  },
  {
    title: "إدارة العقود والمستحقات المالية",
    src: "https://simaat.app/wp-content/uploads/2022/11/buildings.png",
    description:
      "احصل على أفضل برنامج حسابات سحابي مخصص لإدارة الأملاك العقارية ، ينشئ النظام قيود يومية آلية ويدعم مختلف العمليات والتقارير المحاسبية لتوفير وقت وجهد طاقمك المحاسبي.",
  },
  {
    title: "إدارة محاضر مجالس ادارات التجمعات العقارية",
    src: "https://simaat.app/wp-content/uploads/2022/11/buildings.png",
    description:
      "أصدر فواتيرك الإلكترونية آليًا بأمان مع إضافة الشعار والتوقيع الإلكتروني والــ OR Code، الفواتير متطابقة مع متطلبات هيئة الزكاة والضريبة والجمارك والمرحلة الثانية من الفاتورة الإلكترونية.     ",
  },
  {
    title: "طرح المنافسات للتجمع العقاري",
    src: "https://simaat.app/wp-content/uploads/2022/11/buildings.png",
    description:
      "وسع أعمالك ببوابات الخدمات الذاتية لتطوير عملياتك العقارية، بوصول كل من المالك والمستأجر الوسطاء وموظفي الصيانة إلى البوابات الخاصة بهم مما يختصر الإجراءات الروتينية.",
  },
]

export const revalidate = 300
export default async function Home() {
  return (
    <>
      <Header />
      <HeroSection />
      <section className=" bg-slate-50">
        <div className="container py-14">
          <HoverEffect items={projects} />
        </div>
      </section>
      <ZoomFeature />
      <Status />
      <Partners />
      <Suspense
        fallback={
          <div className="flex h-screen items-center justify-center">
            <Loader size={"lg"} />
          </div>
        }>
        <Pricing />
      </Suspense>
      <section id="contact-us">
        <div className="container py-14">
          <GetInTouch />
        </div>
      </section>
      <Footer />
    </>
  )
}
