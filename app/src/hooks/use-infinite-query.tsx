import React, { useEffect } from "react"
import { useParams } from "next/navigation"
import {
  useInfiniteQuery as useReactQueryInfiniteQuery,
  type QueryKey,
} from "@tanstack/react-query"

type Props<T> = {
  queryKey: QueryKey
  fetcher: (args: { pageParam: string; association_id: string }) => Promise<T>
  ref: React.RefObject<HTMLDivElement>
}

type TypicalResponseType = {
  data: {
    from: number
    to: number
    total: number
    per_page: number
    current_page: number
    last_page: number
    next_page_url: null
    previous_page_url: null
  }
  message: null
  success: boolean
}

const useInfiniteQuery = <T extends TypicalResponseType>({
  queryKey,
  fetcher,
  ref,
}: Props<T>) => {
  const params = useParams() as {
    association_id: string
  }

  const query = useReactQueryInfiniteQuery<T>({
    queryKey: [...queryKey, params.association_id],
    queryFn: async ({ pageParam }) => {
      return await fetcher({
        association_id: params.association_id,
        pageParam: pageParam + "",
      })
    },
    initialPageParam: 1,
    getNextPageParam: (lastPage, pages) => {
      return lastPage.data.current_page === lastPage.data.last_page
        ? null
        : lastPage.data.current_page + 1
    },
  })

  useEffect(() => {
    if (
      query.isFetching ||
      query.isFetchingNextPage ||
      !ref.current ||
      !query.hasNextPage ||
      query.isLoading
    )
      return
    const observer = new IntersectionObserver((entries, observe) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          query.fetchNextPage()
        }
      })
    })

    observer.observe(ref.current!)

    return () => {
      observer.disconnect()
    }
  }, [
    query.isFetching,
    query.isFetchingNextPage,
    query.hasNextPage,
    query.fetchNextPage,
    query.isLoading,
    ref,
  ])

  return query
}

export default useInfiniteQuery
