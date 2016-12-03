
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.net.URI;
import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;
import java.util.StringTokenizer;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.mapreduce.Counter;
import org.apache.hadoop.util.GenericOptionsParser;
import org.apache.hadoop.util.StringUtils;

public class WordCountMapper {


 public static class SkipPunctuation
       extends Mapper<Object, Text, Text, IntWritable>{

         private final static IntWritable one = new IntWritable(1);
         private Text word = new Text();

    @Override
    public void map(Object key, Text value, Context context
                    ) throws IOException, InterruptedException {
      String line = value.toString();
      //line = line.replaceAll("'","");
      line = line.replaceAll("[^a-zA-Z]", " ");

      StringTokenizer itr = new StringTokenizer(line);
      while (itr.hasMoreTokens()) {
        word.set(itr.nextToken());
        context.write(word, one);
      }
    }
  }

public static void main(String [] args) throws Exception
{
  Configuration conf = new Configuration();
    Job job = Job.getInstance(conf, "remove punctuation");
    job.setJarByClass(WordCountMapper.class);
    job.setMapperClass(SkipPunctuation.class);
    //job.setCombinerClass(IntSumReducer.class);
    //job.setReducerClass(IntSumReducer.class);
    //job.setSortComparatorClass(DescendingKeyComparator.class);
    job.setOutputKeyClass(Text.class);
    job.setOutputValueClass(IntWritable.class);
    FileInputFormat.addInputPath(job, new Path(args[0]));
    FileOutputFormat.setOutputPath(job, new Path(args[1]));
    System.exit(job.waitForCompletion(true) ? 0 : 1);
}
}
